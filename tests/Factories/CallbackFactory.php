<?php

namespace Tests\Factories;

use Illuminate\Support\Facades\DB;

class CallbackFactory extends BaseFactory
{
    const TABLE = 'callbacks';

    public static function generate($count)
    {
        return factory(\Partymeister\Core\Models\Callback::class, $count)->create();
    }

    public static function truncate()
    {
        DB::table(self::TABLE)->truncate();
    }
}
