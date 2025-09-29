@extends('site.app')
@section('title', __('Success'))
@section('content')
    <!--Thank You secation-->
    <div class="ThankYou mt-1">
        <div class="container">
            <div class="success-icon-container">
                <div class="success-icon">
                    <img src="{{ site_path('img/verified.gif') }}" alt="Verified" class="your-css-class-if-needed" />
                </div>
            </div>
            <div class="row mt-3 mx-3 mx-md-0">

                <div class="col-12 text-center pt-1">
                    <i class="icofont-star star-icon text-secound fs-1 my-1"></i>
                    <div class="text">
                        {{-- <h1 class="text-main display-1" dir="ltr">@lang('Thank you')</h1> --}}

                        <div class="thanks-message">
                            <h2>شكرًا لك على تبرعك الكريم</h2>
                        </div>

                        <div class="thanks-text">
                            <p>جزاك الله خيرًا على عطائك المبارك، فقد كنت سببًا في إدخال السرور على قلوب المحتاجين،
                                وامتثالًا لأمر الله عز وجل في البذل والإنفاق. قال الله تعالى: "مَن ذَا الَّذِي يُقْرِضُ
                                اللَّهَ قَرْضًا حَسَنًا فَيُضَاعِفَهُ لَهُ أَضْعَافًا كَثِيرَةً" - [البقرة: 245] وقال رسول
                                الله ﷺ: "ما نقص مالٌ من صدقة". [رواه مسلم] نسأل الله أن يجعل تبرعك هذا في ميزان حسناتك، وأن
                                يخلف عليك بخير، ويجعل لك به بركة في المال والأهل والولد.</p>
                        </div>
                        @include('site.layouts.message')
                        {{-- <p class="fs-4"> مع تحيات جمعية {{ $settings->getItem('site_name') }} </p> --}}
                        <a href="{{ route('site.home') }}"
                            class="btn bg-main donation-record-btn py-2 my-3 fs-5 btn btn-main">
                            @lang('Back to website')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@php
    $itemLayers = [];
    foreach ($order->details as $item){
        $itemLayers[] = [
            'item_id' => $item->item_id,
            'item_name' => $item->item_name,
            'currency' => 'SAR',
            'price' => $item->price,
            'quantity' => $item->quantity,
        ];
    }
@endphp

<script>
  dataLayer.push({
      'event': 'purchase',
      'ecommerce': {
          'currency': 'SAR',
          'value': {{ $order->total }},
          'transaction_id': '{{ $order->identifier }}',
          'affiliation': 'Hand in Hand Donations',
          'items': @json($itemLayers),
      }
  });
</script>

<script>
  $(document).ready(function () {
  window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        event: "purchase",
        transaction_id: {{ $order->identifier }},
        payment_method: {{ @$order->paymentMethod->payment_key }},
        value: {{ $order->total }},
        currency: "SAR",
    });
  });
</script>

{{--  gtag purchase event  --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      gtag('event', 'purchase', {
          transaction_id: '{{ $order->id }}',
          affiliation: 'Online Store',
          value: '{{ number_format($order->total, 2) }}',
          currency: 'SAR',
          items: [
              @foreach ($order->details as $item)
              {
                  item_id: '{{ $item->id }}',
                  item_name: "{{ $item->item_name }}",
                  price: {{ $item->price }},
                  quantity: {{ $item->quantity }}
              } @if (!$loop->last),@endif
              @endforeach
          ]
      });  
    });  
  </script>


  {{--  snap purchase event  --}}
  <script>
     $(document).ready(function () {
        snaptr('track', 'PURCHASE', {
          'currency': "SAR", 
          'price': '{{ number_format($order->total, 2) }}',
          'transaction_id': '{{ $order->id }}',
          'items': [
              @foreach ($order->details as $item)
                {
                  item_id: '{{ $item->id }}',
                  item_name: "{{ $item->item_name }}",
                  index: {{ $loop->index + 1}},
                  price: {{ $item->price }},
                  quantity: {{ $item->quantity }}
                } @if (!$loop->last),@endif
              @endforeach
            ]
        });     
      });     
  </script>

  {{--  titok purchase event  --}}
  <script>
      $(document).ready(function () {
        ttq.track('CompletePayment', {
          currency: "SAR",
          value: '{{ $order->total }}',
          contents: [
              @foreach ($order->details as $item)
              {
                  content_id: '{{ $item->id }}',
                  content_name: "{{ $item->item_name }}",
                  price: {{ $item->price }},
                  quantity: {{ $item->quantity }}
              } @if (!$loop->last),@endif
              @endforeach
          ],
          content_type: 'product',
          description: 'Purchase with transaction ID: {{ $order->id }}'
      });
    });
  </script>


  {{--  facebook purchase event  --}}
  <script>
    $(document).ready(function () {
      fbq('track', 'purchase', {
        content_ids: "{{ @$order->id }}",
        currency: "SAR", 
        value: '{{ $order->total }}',
        items: [
          @foreach ($order->details as $item)
            {
              item_id: '{{ @$item->id }}',
              item_name: "{{ @$item->item_name }}",
              index: {{ $loop->index + 1 }},
              price: {{ @$item->price }},
              quantity: {{ @$item->quantity }}
            } @if (!$loop->last),@endif
          @endforeach
        ]
      });
    });
  </script>



@endsection




