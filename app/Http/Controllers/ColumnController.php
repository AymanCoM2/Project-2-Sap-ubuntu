<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOptionDDLrequest;
use App\Models\ColumnOption;
use App\Models\ColumnType;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function columnTypesGet()
    {
        $allColumnTypes  = ColumnType::all();
        return view('columnMng.get-column-types', compact('allColumnTypes'));
    }

    public function columnTypesPost(Request $request)
    {
        // Get all column types
        $allColumnTypes = ColumnType::all();
        // Iterate through the column types
        foreach ($allColumnTypes as $column) {
            // Find the corresponding column type in the database
            $editedColumn = ColumnType::where('colName', $column->colName)->first();
            if ($editedColumn) {
                // Update the column type with the value from the request
                $editedColumn->colType = $request->input($column->colName);
                // Save the changes
                $editedColumn->save();
            }
        }
        // Redirect back to the previous page
        return back();
    }
    public function columnDDLGet()
    {
        $allColumnNames  = ColumnType::where('colType', 'ddl')->pluck('colName')->all();
        return view('columnMng.get-column-ddl', compact('allColumnNames'));
    }

    public function columnDDLPost(AddOptionDDLrequest $reuqest)
    {
        $newColOption  = new ColumnOption();
        $newColOption->colName  = $reuqest->theDDL;
        $selectedOption = $newColOption->colName;
        $newColOption->colOption  =  $reuqest->theDDLOption;
        $newColOption->save();
        return back()->with(['selectedOption' => $selectedOption]);
    }
}
