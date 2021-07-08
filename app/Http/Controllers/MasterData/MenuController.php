<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function add(Request $req)
    {
        if($req->menu == "" || $req->route == "" || $req->icon == "" || $req->title == "") {
            return response()->json(["success" => 0, "message" => "Menu, route, icon, dan title harap diisi"], 422);
        } else {
            $menu = new \App\Models\Menu();
            $menu->parentId = $req->parentId;
            $menu->menu = $req->menu;
            $menu->route = $req->route;
            $menu->icon = $req->icon;
            $menu->title = $req->title;
            $menu->save();
    
            return response()->json(["success" => 1]);
        }
    }
}
