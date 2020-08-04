->whereDate('departs_at', '>', Carbon::now())
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orders')
                    ->whereRaw('orders.space_id = spaces.id');
            })
