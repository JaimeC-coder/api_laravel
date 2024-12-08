<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Response\JsonResponse;

use function Illuminate\Log\log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //*Metodo que debe de resivir el año para mostrar la informacion
    public function informationByCategoryBYear(Request $request)
    {
        $year = $request->anio ? $request->anio : date('Y');
        $categoriaMasVendida = DB::table('inventory_transactions')
            ->join('product_unit_price_by_measurements', 'inventory_transactions.productUnitPriceId', '=', 'product_unit_price_by_measurements.productUnitPriceId')
            ->join('products', 'product_unit_price_by_measurements.productId', '=', 'products.productId')
            ->join('categories', 'products.categoryId', '=', 'categories.categoryId')
            ->select('categories.categoryName', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereRaw('YEAR(transactionDate) = ' . $year)
            ->groupBy('categories.categoryName')
            ->orderBy('cantidad', 'desc')
            ->first();
        $categoriaMenosVendida = DB::table('inventory_transactions')
            ->join('product_unit_price_by_measurements', 'inventory_transactions.productUnitPriceId', '=', 'product_unit_price_by_measurements.productUnitPriceId')
            ->join('products', 'product_unit_price_by_measurements.productId', '=', 'products.productId')
            ->join('categories', 'products.categoryId', '=', 'categories.categoryId')
            ->select('categories.categoryName', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereRaw('YEAR(transactionDate) = ' . $year)
            ->groupBy('categories.categoryName')
            ->orderBy('cantidad', 'asc')
            ->first();
        $categoria = DB::table('categories')
            ->leftJoin('products', 'categories.categoryId', '=', 'products.categoryId')
            ->leftJoin('product_unit_price_by_measurements', 'products.productId', '=', 'product_unit_price_by_measurements.productId')
            ->leftJoin('inventory_transactions', 'product_unit_price_by_measurements.productUnitPriceId', '=', 'inventory_transactions.productUnitPriceId')
            ->select(
                'categories.categoryName',
                DB::raw('COALESCE(SUM(inventory_transactions.transactionCount), 0) as cantidad')
            )
            ->whereRaw('YEAR(transactionDate) = ' . $year)
            ->groupBy('categories.categoryName')
            ->get();

        $categoria = [
            'categoriaMasVendida' => $categoriaMasVendida,
            'categoriaMenosVendida' => $categoriaMenosVendida,
            'categoria' => $categoria
        ];

        return JsonResponse::success($categoria, 'informacion para Dashboard', true, 1, 200);
    }
    //*Metodo que debe de resivir el año
    public function informationByTemporada(Request $request)
    {
        log($request);
        $year = $request->anio ? $request->anio : date('Y');
        $totalAnual = DB::table('inventory_transactions')
            ->whereRaw('YEAR(transactionDate) = ' . $year)
            ->sum('transactionCount');
        //invierno
        $invierno  = DB::table('inventory_transactions')
            ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereYear('transactionDate', $year)
            ->whereIn(DB::raw('MONTH(transactionDate)'), [12, 1, 2])
            ->groupBy('transactionType')
            ->get();
        $totalInvierno = $invierno->sum('cantidad');
        $porcentajeInvierno = $totalAnual > 0 ? ($totalInvierno / $totalAnual) * 100 : 0;
        //verano
        $verano = DB::table('inventory_transactions')
            ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereRaw('YEAR(transactionDate) = ' . $year)
            ->whereIn(DB::raw('MONTH(transactionDate)'), [3, 4, 5])
            ->groupBy('transactionType')
            ->get();
        $totalVerano = $verano->sum('cantidad');
        $porcentajeVerano = $totalAnual > 0 ? ($totalVerano / $totalAnual) * 100 : 0;

        //otoño
        $otono = DB::table('inventory_transactions')
            ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereRaw('YEAR(transactionDate) = ' . $year)
            ->whereIn(DB::raw('MONTH(transactionDate)'), [6, 7, 8])
            ->groupBy('transactionType')
            ->get();
        $totalOtono = $otono->sum('cantidad');
        $porcentajeOtono = $totalAnual > 0 ? ($totalOtono / $totalAnual) * 100 : 0;


        //primavera
        $primavera = DB::table('inventory_transactions')
            ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereRaw('YEAR(transactionDate) = ' . $year)
            ->whereIn(DB::raw('MONTH(transactionDate)'), [9, 10, 11])
            ->groupBy('transactionType')
            ->get();

        $totalPrimavera = $primavera->sum('cantidad');
        $porcentajePrimavera = $totalAnual > 0 ? ($totalPrimavera / $totalAnual) * 100 : 0;


        $grafica = [
            'invierno' => [
                'transacciones' => $invierno,
                'porcentaje' => round($porcentajeInvierno,2)
            ],
            'verano' => [
                'transacciones' => $verano,
                'porcentaje' => round($porcentajeVerano,2)
            ],
            'otono' => [
                'transacciones' => $otono,
                'porcentaje' => round($porcentajeOtono,2)
            ],
            'primavera' => [
                'transacciones' => $primavera,
                'porcentaje' => round($porcentajePrimavera,2)
            ]
        ];

        return JsonResponse::success($grafica, 'informacion para Dashboard', true, 1, 200);
    }

    //* Metodo que debe de resivir 2 años para comparar
    public function inputOuput(Request $request)
    {
        log($request);

        $year1 = $request->anio1 ? $request->anio1 : date('Y');
        $year2 = $request->anio2 ? $request->anio2 : date('Y');

        if ($year1 == $year2) {
            $entradasSalidas1 = DB::table('inventory_transactions')
                ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
                ->whereRaw('YEAR(transactionDate) = ' . $year1)
                ->groupBy('transactionType')
                ->get();
            return JsonResponse::success($entradasSalidas1, 'Entradas y salidas de productos', true, 1, 200);
        }
        $entradasSalidas1 = DB::table('inventory_transactions')
            ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereRaw('YEAR(transactionDate) = ' . $year1)
            ->groupBy('transactionType')
            ->get();
        $entradasSalidas2 = DB::table('inventory_transactions')
            ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
            ->whereRaw('YEAR(transactionDate) = ' . $year2)
            ->groupBy('transactionType')
            ->get();

        $entradasSalidas = [
            'year1' => $entradasSalidas1,
            'year2' => $entradasSalidas2
        ];
        return JsonResponse::success($entradasSalidas, 'Entradas y salidas de productos', true, 1, 200);
    }

    //* Metodo que debe de resivir el id del producto
    //!aqui falta terminar el ingreso del id del producto
    public function inputOuputXMes(Request $request)
    {
        log($request);
        $year = $request->anio ? $request->anio : date('Y');
        $productId = $request->product ? $request->product : 0;
        if ($productId === 0) {
            $entradasSalidasXMes = DB::table('inventory_transactions')
                ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'), DB::raw('MONTH(transactionDate) as mes'))
                ->whereRaw('YEAR(transactionDate) = ' . $year)
                ->groupBy('transactionType', 'mes')
                ->get();
            return JsonResponse::success($entradasSalidasXMes, 'Entradas y salidas de productos por mes', true, 1, 200);
        }


        $entradasSalidasXMes = DB::table('inventory_transactions')
            ->join('product_unit_price_by_measurements', 'inventory_transactions.productUnitPriceId', '=', 'product_unit_price_by_measurements.productUnitPriceId')
            ->select(
                'inventory_transactions.transactionType',
                DB::raw('SUM(inventory_transactions.transactionCount) as cantidad'),
                DB::raw('MONTH(inventory_transactions.transactionDate) as mes')
            )
            ->where('product_unit_price_by_measurements.productId', $productId) // Filtro por el ID del producto
            ->whereRaw('YEAR(inventory_transactions.transactionDate) = ' . $year)
            ->groupBy('inventory_transactions.transactionType', 'mes')
            ->get();


        return JsonResponse::success($entradasSalidasXMes, 'Entradas y salidas de productos por mes', true, 1, 200);
    }



    public function filterYear()
    {
        $years = DB::table('inventory_transactions')
            ->select(DB::raw('YEAR(transactionDate) as year'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
        return JsonResponse::success($years, 'Lista de años', true, 1, 200);
    }

    public function filterProduct()
    {
        $products = DB::table('inventory_transactions')
            ->join('product_unit_price_by_measurements', 'inventory_transactions.productUnitPriceId', '=', 'product_unit_price_by_measurements.productUnitPriceId')
            ->join('products', 'product_unit_price_by_measurements.productId', '=', 'products.productId')
            ->select('products.productId', 'products.productName')
            ->distinct() // Asegura que no se repitan productos
            ->get();

        return JsonResponse::success($products, 'Lista de productos', true, 1, 200);
    }
}
