<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopListController extends Controller
{
    public function index() {
        return view("toplist.index", [
            "title" => "Netflix toplista",
            "mostWatchedTitle" => DB::table("toplist")->orderByDesc("weekly_hours_viewed")->value("show_title"),
            "lastWeek" => DB::table("toplist")->max("week"),
            "sumHours" => DB::table("toplist")->sum("weekly_hours_viewed")
        ]);
    }
    public function toplist(){
        $builder = DB::table("toplist");
        $items = $builder->paginate(10);
        
        return view("toplist.table", [
            "title" => "Netflix toplista",
            "items" => $items 
        ]);
    }

    public function category(string $category_name){
        $builder = DB::table("toplist");
        $items = $builder->where("category", "=", $category_name)->paginate(10);
        return view("toplist.table", [
            "title" => "Kategoria: " . $category_name,
            "items" => $items
        ]);
    }

    public function categories(){
        $builder = DB::table("toplist");
        $categories = $builder->distinct()->pluck("category");
        return view("toplist.categories", [
            "title" => "Kategoriak",
            "categories" => $categories
        ]);
    }
    public function films(){
        $builder = DB::table("toplist");
        $items = $builder->where("category", "like", "Films%")->paginate(10);
        return view("toplist.table", [
            "title" => "Netflix filmek toplista",
            "items" => $items
        ]);
    }

    public function tvs(){
        $builder = DB::table("toplist");
        $items = $builder->where("category", "like", "TV%")->paginate(10);
        return view("toplist.table", [
            "title" => "Netflix sorozatok toplista",
            "items" => $items
        ]);
    }

    public function popular(){
        $builder = DB::table("toplist");
        $items = $builder
            ->orWhere("cumulative_weeks_in_top_ten", ">=", 23)
            ->orWhere("weekly_hours_viewed", ">=", 158680000)
            ->orderByDesc("weekly_hours_viewed")->paginate(10);
        return view("toplist.table", [
            "title" => "Nepszeru musorok", 
            "items" => $items
        ]);
    }

    public function week($week, Request $request){
        $orderBy = $request ->query("orderBy");
        $builder = DB::table("toplist");
        switch ($orderBy){
            case "category":
                $items = $builder->where("week", "=", $week)->orderBy("category")->paginate(10);
                break;
            case "weekly_rank":
                $items = $builder->where("week", "=", $week)->orderBy("weekly_rank")->paginate(10);
                break;
            case "weekly_hours_viewed":
                $items = $builder->where("week", "=", $week)->orderByDesc("weekly_hours_viewed")->paginate(10);
                break;
            default: 
                $items = $builder->where("week", "=", $week)->paginate(10);
                break;
        }
        return view("toplist.table", [
            "title" => "Heti adatok: " . $week,
            "week" => $week,
            "items" => $items
        ]);
    }

    public function top1($week){
        $builder = DB::table("toplist");
        $mostWatched = $builder->where("category", "like", "%(English)")->where("week", "=", $week)->orderBy("weekly_rank")->value("show_title");
        return view("toplist.top1", [
            "title" => "Top 1 " . $week,
            "showTitle" => $mostWatched 
        ]);
    }
}
