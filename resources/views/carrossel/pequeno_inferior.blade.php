@include('carrossel._carrossel', ['id' => 'slide-bottom-left', 'itens' => ($carrossel ?? collect())->slice(5, 2)->values(), 'fonte' => '12px'])
