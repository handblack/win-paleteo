<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VlBpartner;
use App\Models\VlCurrency;
use App\Models\VlDocType;
use App\Models\VlOrder;
use App\Models\VlSequence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VlOrder>
 */
class VlOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dot = VlDocType::whereDoctypeGroupId(5)->whereDoctypecode('PE')->first();
        $seq = VlSequence::inRandomOrder()->whereDoctypeId($dot->id)->first();
        $nro = $seq->get_lastnumber($seq->id);
        $seq->set_lastnumber($seq->id);
        return [
            'dateorder'     => date('Y-m-d'),
            'docstatus'     => 'C',
            'serial'        => $seq->serial,
            'documentno'    => $nro,
            'sequence_id'   => $seq->id,
            'doctype_id'    => $dot->id,
            'bpartner_id'   => VlBpartner::inRandomOrder()->first()->id,
            'currency_id'   => VlCurrency::first()->id,
            'created_by'    => User::inRandomOrder()->first()->id,
            'token'         => User::get_token(),
        ];
    }
}
