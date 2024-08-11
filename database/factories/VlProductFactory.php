<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VlProductAcabado;
use App\Models\VlProductCategory;
use App\Models\VlProductFamilia;
use App\Models\VlProductFamily;
use App\Models\VlProductGama;
use App\Models\VlProductGroup;
use App\Models\VlProductHilatura;
use App\Models\VlProductLine;
use App\Models\VlProductPresentacion;
use App\Models\VlProductSubFamilia;
use App\Models\VlProductSubLine;
use App\Models\VlProductTejido;
use App\Models\VlProductTenido;
use App\Models\VlProductTitulo;
use App\Models\VlProductUM;
use App\Models\VlUm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VlProduct>
 */
class VlProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        

        $ancho = fake()->randomElements([
            '80',
            '85',
            '90',
        ]);

        $mt = fake()->randomElements([
            'ALGODON',
            'PEINADO',
            'POLYALGODON',
        ]);

        $ne = fake()->randomElements([
            '30/1',
            '28/1',
        ]);

        $familia    = VlProductFamilia::inRandomOrder()->first();
        $tejido     = VlProductTejido::where('id','>',1)->inRandomOrder()->first();
        $color      = VlProductGama::inRandomOrder()->first();
        $um         = VlProductUM::whereShortname('KG')->first();
        $titulo     = VlProductTitulo::whereIn('identity',['30/1','28/1'])->inRandomOrder()->first();
        $group      = VlProductGroup::inRandomOrder()->first();

        $pn = "{$tejido->identity} {$titulo->identity} " . implode('',$mt) . ' ' . implode('',$ancho) . " {$color->identity}";
        $code = User::get_param('SEQUENCE.PRODUCT.SKU');
        $code++;
        User::set_param('SEQUENCE.PRODUCT.SKU',$code);
        return [
            'productname'       => $pn,
            'productcode'       => str_pad($code,4,'0',STR_PAD_LEFT),
            'token'             => User::get_token(),
            'um_id'             => $um->id,
            'familia_id'        => $familia->id,
            'subfamilia_id'     => VlProductSubFamilia::first(),
            'tejido_id'         => $tejido->id,
            'hilatura_id'       => 1,
            'titulo_id'         => $titulo->id,
            'gama_id'           => $color->id,
            'tenido_id'         => VlProductTenido::first(),
            'acabado_id'        => 1,
            'presentacion_id'   => 1,
            'group_id'          => $group->id,
            'created_by'        => 1,
        ];
    }
}
