<?php

namespace App\Http\Controllers;

use App\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display the rules
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Rule::firstOrCreate([
            'content' => "",
        ]);
    }

    /**
     * Update the rules
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = Rule::all()->first();
        $rules->content = $request->content;
        $rules->save();

        return $rules;
    }
}
