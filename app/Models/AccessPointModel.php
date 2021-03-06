<?php

/*
 * Copyright 2017 Niels Klazenga, Royal Botanic Gardens Victoria.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace VicFlora\Models;

use Illuminate\Support\Facades\DB;

/**
 * Description of AccessPointModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class AccessPointModel {
    
    public function getAccessPoint($id)
    {
        try {
            return DB::table('images.image_access_points as a')
            ->select('a.id', 'a.guid as access_point_id', 'v.name as variant', 
                    'a.access_uri', 'a.format', 'a.pixel_x_dimension', 
                    'a.pixel_y_dimension')
            ->join('images.images as i', 'a.image_id', '=', 'i.id')
            ->join('vocab.variant_vocab as v', 'a.variant_id', '=', 'v.id')
            ->where('a.guid', $id)
            ->first();
        }
        catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }
}
