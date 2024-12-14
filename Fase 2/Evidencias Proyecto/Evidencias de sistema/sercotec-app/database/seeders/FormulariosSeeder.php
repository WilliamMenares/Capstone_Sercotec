<?php

namespace Database\Seeders;

use App\Models\Ambitos;
use App\Models\Preguntas;
use App\Models\RespuestasTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormulariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RespuestasTipo::insert([
            [
                'titulo' => 'Cumple',
                'puntaje' => 5,
            ],
            [
                'titulo' => 'Cumple Parcialmente',
                'puntaje' => 3,
            ],
            [
                'titulo' => 'No Cumple',
                'puntaje' => 1,
            ],
        ]);

        Ambitos::insert([
            ['title' => 'Comercial (DL)'],
            ['title' => 'Financiero & Contable (RT)'],
            ['title' => 'Operaciones & Logistcia (FP)'],
            ['title' => 'Planificación & Análisis (ME)'],
            ['title' => 'RRHH (IB)'],
        ]);


        $Comercial = Ambitos::where('title', 'Comercial (DL)')->first();
        $Financiero = Ambitos::where('title', 'Financiero & Contable (RT)')->first();
        $Operaciones = Ambitos::where('title', 'Operaciones & Logistcia (FP)')->first();
        $Planificacion = Ambitos::where('title', 'Planificación & Análisis (ME)')->first();
        $RRHH = Ambitos::where('title', 'RRHH (IB)')->first();




        // Crear las 6 preguntas para el ámbito Comercial
        Preguntas::insert([
            [
                'title' => '¿La empresa tiene una estrategia comercial definida con objetivos claros a corto, mediano y largo plazo? (Esta pregunta busca saber si el negocio tiene un plan para vender sus productos o servicios. ¿Sabe la empresa qué quiere lograr en el futuro cercano (por ejemplo, en los próximos 6 meses), a mediano plazo (un año) y a largo plazo (más de un año)? Tener objetivos claros ayuda a dirigir las acciones del negocio para crecer y mejorar las ventas.)',
                'ambito_id' => $Comercial->id,
                'prioridad' => 1,
            ],
            [
                'title' => '¿La empresa mide regularmente la satisfacción de sus clientes y utiliza los resultados para mejorar productos o servicios? (Aquí queremos saber si el negocio le pregunta a sus clientes si están contentos con lo que compraron o el servicio que recibieron. Saber qué piensan los clientes es importante para hacer mejoras y asegurarse de que regresen. ¿El negocio hace encuestas o preguntas a los clientes para saber si están satisfechos y usa esa información para mejorar?)',
                'ambito_id' => $Comercial->id,
                'prioridad' => 2,
            ],
            [
                'title' => '¿La empresa tiene estrategias claras para retener a los clientes, como programas de lealtad o atención postventa? (Esta pregunta se enfoca en si el negocio tiene formas de mantener a los clientes actuales y hacer que vuelvan. ¿El negocio ofrece beneficios por ser cliente habitual, como descuentos o promociones especiales? Además, ¿hacen seguimiento después de la compra para asegurarse de que el cliente esté contento y regrese?)',
                'ambito_id' => $Comercial->id,
                'prioridad' => 3,
            ],
            [
                'title' => '¿La empresa utiliza activamente medios tradicionales (publicidad impresa, eventos, etc.) para atraer y mantener a los clientes? (Esta pregunta trata de saber si el negocio usa medios como volantes, carteles, anuncios en la radio o participa en eventos locales para promocionarse. ¿El negocio hace este tipo de actividades para atraer nuevos clientes o recordar a los clientes actuales que vuelvan?)',
                'ambito_id' => $Comercial->id,
                'prioridad' => 4,
            ],
            [
                'title' => '¿La empresa tiene una estrategia de marketing digital clara, utilizando redes sociales, campañas pagadas y SEO/SEM? (Queremos saber si el negocio está usando internet y redes sociales como Facebook, Instagram o Google para promocionarse. ¿Publican contenido, pagan por anuncios o usan estrategias para que el negocio aparezca en las búsquedas de Google? El marketing digital ayuda a atraer más clientes en línea.)',
                'ambito_id' => $Comercial->id,
                'prioridad' => 5,
            ],
            [
                'title' => '¿La empresa realiza un análisis periódico del comportamiento de sus clientes y la competencia para ajustar sus estrategias comerciales? (Esta pregunta busca saber si el negocio observa y estudia tanto a sus propios clientes como a la competencia (otros negocios similares). ¿Saben qué prefieren los clientes, y qué están haciendo los competidores para mejorar sus propias estrategias de venta? Este análisis es útil para ajustar las ofertas y mantenerse competitivo en el mercado.)',
                'ambito_id' => $Comercial->id,
                'prioridad' => 6,
            ],
            [
                'title' => '¿Se realiza un control adecuado del flujo de caja para garantizar liquidez en el corto plazo?',
                'ambito_id' => $Financiero->id,
                'prioridad' => 2
            ],
            [
                'title' => '¿Se gestionan eficientemente los costos, se han calculado correctamente los precios y el punto de equilibrio para asegurar la rentabilidad?',
                'ambito_id' => $Financiero->id,
                'prioridad' => 1
            ],
            [
                'title' => '¿Se realiza un análisis de los estados financieros (EERR y balance) y se evalúa la rentabilidad de las operaciones?',
                'ambito_id' => $Financiero->id,
                'prioridad' => 4
            ],
            [
                'title' => '¿Se lleva un control adecuado de los antecedentes tributarios y se cumplen las obligaciones fiscales a tiempo?',
                'ambito_id' => $Financiero->id,
                'prioridad' => 3
            ],
            [
                'title' => '¿Se evalúan adecuadamente las opciones de financiamiento y se gestionan de manera estratégica las inversiones?',
                'ambito_id' => $Financiero->id,
                'prioridad' => 5
            ],
            [
                'title' => '¿Se tiene un presupuesto anual definido y se compara regularmente con los resultados reales?',
                'ambito_id' => $Financiero->id,
                'prioridad' => 6
            ],
            [
                'title' => '¿Los tiempos de producción y logística están optimizados?',
                'ambito_id' => $Operaciones->id,
                'prioridad' => 5
            ],
            [
                'title' => '¿Se gestionan adecuadamente los inventarios y stocks?',
                'ambito_id' => $Operaciones->id,
                'prioridad' => 1
            ],
            [
                'title' => '¿Existen cuellos de botella en la cadena de suministro?',
                'ambito_id' => $Operaciones->id,
                'prioridad' => 4
            ],
            [
                'title' => '¿La calidad del producto o servicio está estandarizada y es consistente?',
                'ambito_id' => $Operaciones->id,
                'prioridad' => 3
            ],
            [
                'title' => '¿Se revisan periódicamente las relaciones con proveedores para mejorar costos y tiempos de entrega?',
                'ambito_id' => $Operaciones->id,
                'prioridad' => 2
            ],
            [
                'title' => '¿Los procesos operativos están diseñados para maximizar la eficiencia y reducir desperdicios?',
                'ambito_id' => $Operaciones->id,
                'prioridad' => 6
            ],
        ]);




    }
}
