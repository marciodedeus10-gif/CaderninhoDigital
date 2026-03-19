<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemVendaController extends Controller
{
    public function destroy($id)
    {
        $item = ItemVenda::findOrFail($id);
        $item->delete();

        return back();
    }
}
