@php use Illuminate\Support\Arr; @endphp

<div>
   <div class="relative grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="">
         @include('livewire.print-by-label-group-form.label-group-select')

         @include('livewire.print-by-label-group-form.product-list')
      </div>

      <div >

         @include('livewire.print-by-label-group-form.label-group-image')

         @include('livewire.print-by-label-group-form.queue')

      </div>
   </div>

   @if (session()->has('success'))
      <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-400" role="alert">
         {{ session('success') }}
      </div>
   @endif
   @if (session()->has('error'))
      <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-400" role="alert">
         {{ session('error') }}
      </div>
   @endif


   @include('livewire.print-by-label-group-form.modal-batch-select')

   @include('livewire.print-by-label-group-form.printable-area')


</div>
