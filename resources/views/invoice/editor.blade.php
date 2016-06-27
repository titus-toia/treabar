<html>
	<head>
		<meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
		<title data-attribute="name">{{ $invoice->name or 'Invoice' }}</title>
    <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
		<link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <script src="{{ asset('foundation/js/vendor/jquery.js') }}"></script>
		<script src="{{ asset('js/invoice.js') }}"></script>
    <script>
      @if(isset($invoice))
      var url = '{{ route("invoice.update", ['invoice' => $invoice]) }}';
      var method = 'put';
      @else
      var method = 'post';
      var url = '{{ route("invoice.store") }}';
      @endif
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    </script>
	</head>
	<body>
		<header>
			<h1><span contenteditable>Invoice</span></h1>
			<address contenteditable data-attribute="client">
				{{ $invoice->client or 'Client Name' }}
			</address>
			<span><img alt="" src=""></span>
		</header>
		<article>
			<h1>Recipient</h1>
			<address contenteditable data-attribute="company">
				{{ $invoice->company or 'Issuing Company' }}
			</address>
			<table class="meta">
				<tr>
					<th><span>Invoice #</span></th>
					<td><span>{{ $invoice->invoiceno or 'Invoice #' }}</span></td>
				</tr>
				<tr>
					<th><span>Date</span></th>
					<td><span data-attribute="issued_at" contenteditable>{{ $invoice->issued_at or 'Issued at' }}</span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span>Item</span></th>
						<th><span>Description</span></th>
						<th><span>Rate</span></th>
						<th><span>Hours</span></th>
						<th><span>Price</span></th>
					</tr>
				</thead>
				<tbody>
            @if(is_array($invoice->items))
              @foreach($invoice->items as $item)
              <tr>
                <td><a class="cut">-</a><span data-field="name" contenteditable>{{ $item->name or '' }}</span></td>
                <td><span data-field="description" contenteditable>{{ $item->description or '' }}</span></td>
                <td><span data-prefix>$</span><span data-field="rate" contenteditable>{{ $item->rate or 0 }}</span></td>
                <td><span data-field="hours" contenteditable>{{ $item->hours or 0 }}</span></td>
                <td><span data-field="total" data-prefix >$</span><span>{{ $item->total or 0 }}</span></td>
              </tr>
              @endforeach
            @else
              <tr>
                <td><a class="cut">-</a><span data-field="name" contenteditable></span></td>
                <td><span data-field="description" contenteditable></span></td>
                <td><span data-prefix>$</span><span data-field="rate" contenteditable>0.00</span></td>
                <td><span data-field="hours" contenteditable>0</span></td>
                <td><span data-field="total" data-prefix >$</span><span>0.00</span></td>
              </tr>
            @endif
				</tbody>
			</table>
			<a class="add">+</a>
			<table class="balance">
				<tr>
					<th><span>Total</span></th>
					<td><span data-prefix>$</span><span>{{ $invoice->total()['total'] or '0.00' }}</span></td>
				</tr>
			</table>
		</article>
	</body>
</html>