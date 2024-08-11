<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VlParameter;
use App\Models\VlUbigeo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VlBPartner>
 */
class VlBPartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = implode(fake()->randomElements(['1', '2']));        
        $name = $code == 2 ? fake()->company() : fake()->name();  
        $code = fake()->regexify('[1-2]{1}0[0-9]{8}[0-9]{1}');
        $cla  = VlParameter::inRandomOrder()->whereGroupId(5)->first()->id;
        $ubi  = VlUbigeo::inRandomOrder()->first()->id;
        return [
            'bpartnername'  => strtoupper($name),
            'bpartnertype'  => 'C',
            'bpartnercode'  => 'C'. $code,
            'documentno'    => $code,
            'doctype_id'    => 1,
            'pricelist_id'  => implode(fake()->randomElements(['1','2','3','4','5','6','7','8','9'])),
            'salesperson_id'=> implode(fake()->randomElements(['1','2','3'])),
            'clasifica_id'  => $cla,
            'ubigeo_id'     => $ubi,
            'token'         => User::get_token(),
        ];
    }
}
