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
 * Description of ReferenceModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class NameModel 
{
    public function getName($id)
    {
        return DB::table('flora.names as n')
                ->select('n.id', 'vnt.name as name_type', 'n.name', 
                        'n.full_name', 'n.authorship', 
                        'r.guid as name_published_in', 'n.nomenclatural_note', 
                        'r.guid as protologue', 'ca.guid as creator',
                        'ma.guid as modified_by', 'n.timestamp_created', 
                        'n.timestamp_modified', 'n.guid', 'n.version')
                ->leftJoin('vocab.name_type_vocab as vnt',
                        'n.name_type_id', '=', 'vnt.id')
                ->leftJoin('public.references as r', 
                        'n.protologue_id', '=', 'r.id')
                ->leftJoin('public.agents as ca',
                        'n.created_by_id', '=', 'ca.id')
                ->leftJoin('public.agents as ma', 
                        'n.modified_by_id', '=', 'ma.id')
                ->where('n.guid', '=', $id)
                ->first();
    }
}
