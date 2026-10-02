@include('carrossel._carrossel', ['id' => 'slide-top-left', 'itens' => ($carrossel ?? collect())->slice(3, 2)->values(), 'classe' => 'mb-1', 'fonte' => '12px'])
