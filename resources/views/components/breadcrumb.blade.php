{{-- filepath: /Users/msrnayeem/Desktop/Development/ecommerce/resources/views/components/breadcrumb.blade.php --}}
<div class="breadcrumb bg-bgPrimary py-4">
    <nav class="container text-xs flex justify-between items-center">
        <ol class="flex flex-wrap items-center">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="px-1 md:px-2">
                    @if (!$loop->last)
                        <a href="{{ $breadcrumb['url'] }}" class="">{{ $breadcrumb['label'] }}</a>
                        <i class="bi bi-chevron-right"></i>
                    @else
                        {{ $breadcrumb['label'] }}
                    @endif
                </li>
            @endforeach
        </ol>
        <ol class="flex items-center">
            <li>
                <i class="bi bi-chevron-left"></i>
            </li>
            <li class="px-1 md:px-2"><a href="{{ $backUrl }}" class="">Back to Homee</a></li>
        </ol>
    </nav>
</div>
