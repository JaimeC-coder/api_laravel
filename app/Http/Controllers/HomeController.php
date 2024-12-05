<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Response\JsonResponse;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $entradasSalidas = DB::table('inventory_transactions')
            ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
            ->groupBy('transactionType')
            ->get();
            //entradas y salidas de productos por mes
            $entradasSalidasXMes = DB::table('inventory_transactions')
                ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'), DB::raw('MONTH(transactionDate) as mes'))
                ->groupBy('transactionType', 'mes')
            ->get();
            //entrada y salida de productos por temporada (invierno, verano, otoño, primavera)
          //Cantidad de transacciones por mes
                $grafica = [
                'ventasXMes' => $this->countProductsXMonthByYear(),
                'categoria' => $this->informationByCategoryBYear(),
                'entradasSalidas' => $entradasSalidas,
                'entradasSalidasXMes' => $entradasSalidasXMes,
                'temporadas' => $this->informationByTemporada(),
                'TransaccionesXMes' => $this->transactionXMesByYear()
            ];

            return JsonResponse::success($grafica, 'informacion para Dashboard', true, 1, 200);
        } catch (\Throwable $th) {
            log("----------Error Categoria Crear----------");
            log($th->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $th->getMessage(), false, 0, 500);
        }
    }


    public function dashboardFilter(){
        try{
            //Lista de años en los que se han realizado transacciones
            $years = DB::table('inventory_transactions')
                ->select(DB::raw('YEAR(transactionDate) as year'))
                ->groupBy('year')
                ->get();
            //return JsonResponse::success($years, 'Lista de años', true, 1, 200);
            //Lista de meses en los que se han realizado transacciones
            $months = DB::table('inventory_transactions')
                ->select(DB::raw('MONTH(transactionDate) as month'))
                ->groupBy('month')
                ->get();
            //return JsonResponse::success($months, 'Lista de meses', true, 1, 200);
            $ventasXMes = DB::table('inventory_transactions')
                ->join('product_unit_price_by_measurements', 'inventory_transactions.productUnitPriceId', '=', 'product_unit_price_by_measurements.productUnitPriceId')
                ->join('products', 'product_unit_price_by_measurements.productId', '=', 'products.productId')
                ->select(
                    DB::raw('YEAR(transactionDate) as year'),
                    DB::raw('MONTH(transactionDate) as mes'),
                    DB::raw('SUM(transactionCount) as cantidad'),
                    'inventory_transactions.transactionType',
                    'products.productId',
                    'products.productName'
                )
                ->groupBy('year', 'mes', 'products.productId', 'inventory_transactions.transactionType')
                ->orderBy('year', 'asc')
                ->get();
            return JsonResponse::success($ventasXMes, 'Lista de transacciones de entrada', true, 1, 200);

        }catch (\Throwable $th) {
            log("----------Error Categoria Crear----------");
            log($th->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $th->getMessage(), false, 0, 500);
        }
    }


    public function countProductsXMonthByYear($year= null){

          $year = $year ?? date('Y');
         if($year == null){
            $ventasXMes = DB::table('inventory_transactions')
            ->select(DB::raw('MONTH(transactionDate) as mes'), DB::raw('SUM(transactionCount) as cantidad'))
            ->where('transactionDate','=', $year)
            ->groupBy('mes')
            ->get();
         }else{
            $ventasXMes = DB::table('inventory_transactions')
            ->select(DB::raw('MONTH(transactionDate) as mes'), DB::raw('SUM(transactionCount) as cantidad'))
            ->groupBy('mes')
            ->get();
         }

        return $ventasXMes;

    }

    public function informationByCategoryBYear($year = null){
            //categoria mas vendida
            $categoriaMasVendida = DB::table('inventory_transactions')
                ->join('product_unit_price_by_measurements', 'inventory_transactions.productUnitPriceId', '=', 'product_unit_price_by_measurements.productUnitPriceId')
                ->join('products', 'product_unit_price_by_measurements.productId', '=', 'products.productId')
                ->join('categories', 'products.categoryId', '=', 'categories.categoryId')
                ->select('categories.categoryName', DB::raw('SUM(transactionCount) as cantidad'))
                ->groupBy('categories.categoryName')
                ->orderBy('cantidad', 'desc')
                ->first();
            //categoia menos vendida
            $categoriaMenosVendida = DB::table('inventory_transactions')
                ->join('product_unit_price_by_measurements', 'inventory_transactions.productUnitPriceId', '=', 'product_unit_price_by_measurements.productUnitPriceId')
                ->join('products', 'product_unit_price_by_measurements.productId', '=', 'products.productId')
                ->join('categories', 'products.categoryId', '=', 'categories.categoryId')
                ->select('categories.categoryName', DB::raw('SUM(transactionCount) as cantidad'))
                ->groupBy('categories.categoryName')
                ->orderBy('cantidad', 'asc')
                ->first();

            //cantidad de productos vendidas por categoria
            $categoria = DB::table('categories')
                ->leftJoin('products', 'categories.categoryId', '=', 'products.categoryId')
                ->leftJoin('product_unit_price_by_measurements', 'products.productId', '=', 'product_unit_price_by_measurements.productId')
                ->leftJoin('inventory_transactions', 'product_unit_price_by_measurements.productUnitPriceId', '=', 'inventory_transactions.productUnitPriceId')
                ->select(
                    'categories.categoryName',
                    DB::raw('COALESCE(SUM(inventory_transactions.transactionCount), 0) as cantidad')
                )
                ->groupBy('categories.categoryName')
                ->get();

            return [
                'categoriaMasVendida' => $categoriaMasVendida,
                'categoriaMenosVendida' => $categoriaMenosVendida,
                'categoria' => $categoria
            ];


    }

    public function informationByTemporada($year = null){
        $year = $year ?? date('Y');
         //invierno
         $invierno = DB::table('inventory_transactions')
         ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
         ->whereMonth('transactionDate', '12')
         ->orWhereMonth('transactionDate', '1')
         ->orWhereMonth('transactionDate', '2')
         ->groupBy('transactionType')
         ->get();
     //verano
     $verano = DB::table('inventory_transactions')
         ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
         ->whereMonth('transactionDate', '3')
         ->orWhereMonth('transactionDate', '4')
         ->orWhereMonth('transactionDate', '5')
         ->groupBy('transactionType')
         ->get();
     //otoño
     $otono = DB::table('inventory_transactions')
         ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
         ->whereMonth('transactionDate', '6')
         ->orWhereMonth('transactionDate', '7')
         ->orWhereMonth('transactionDate', '8')
         ->groupBy('transactionType')
         ->get();

     //primavera
     $primavera = DB::table('inventory_transactions')
         ->select('transactionType', DB::raw('SUM(transactionCount) as cantidad'))
         ->whereMonth('transactionDate', '9')
         ->orWhereMonth('transactionDate', '10')
         ->orWhereMonth('transactionDate', '11')
         ->groupBy('transactionType')
         ->get();

         return [
             'invierno' => $invierno,
             'verano' => $verano,
             'otono' => $otono,
             'primavera' => $primavera
         ];


    }

    public function transactionXMesByYear($year = null){
        $TransaccionesXMes = DB::table('inventory_transactions')
        ->select(DB::raw('MONTH(transactionDate) as mes'), DB::raw('count(transactionCount) as cantidad'))
        ->groupBy('mes')->get();

        return $TransaccionesXMes;
    }

}
