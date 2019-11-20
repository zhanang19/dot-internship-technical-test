<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewTaskOneController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $temp = $request->input('array');
        if (! empty($temp)) {
            foreach (explode(',', $temp) as $value) {
                $array[] = intval($value);
            }
        } else {
            $array = [5, 5, 6, 1, 4, 3];
        }
        $oldArray = $array;
        rsort($array, SORT_NUMERIC);
        return response()->json([
            'old_array' => $oldArray,
            'sorted_array' => $array,
            'second_largest' => $array[1] ?? $array[0]
        ]);
    }
}
