@extends('layouts.app')

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb bg-bgPrimary py-4">
        <nav class="container text-xs flex justify-between items-center">
            <ol class="flex flex-wrap items-center">
                <li class="px-1 md:px-2"><a href="../index.html" class="">Home</a></li>
                <li>
                    <i class="bi bi-chevron-right"></i>
                </li>
                <li class="px-1 md:px-2">Terms & Conditions</li>
            </ol>
            <ol class="flex items-center">
                <li>
                    <i class="bi bi-chevron-left"></i>
                </li>
                <li class="px-1 md:px-2"><a href="../index.html" class="">Back to Home</a></li>
            </ol>
        </nav>
    </div>

    <section class="py-4">
        <div class="container">
            <div class="py-12 md:py-16 lg:py-20">
                <h1 class="uppercase text-xl text-center font-bold mb-5">Terms & Conditions</h1>
                <h3><strong>শর্তাবলী</strong></h3>

                <p>আমাদের ওয়েবসাইট ব্যবহার করার মাধ্যমে আপনি নিম্নলিখিত শর্তাবলী মেনে নিতে সম্মত হচ্ছেন। এই শর্তাবলী বাংলাদেশে প্রযোজ্য আইন অনুযায়ী প্রণীত।</p>

                <h4>✅ <strong>পণ্য ক্রয়:</strong></h4>
                <p>আমাদের ওয়েবসাইট থেকে পণ্য ক্রয় করার সময়, আপনি নিশ্চিত করবেন যে আপনি সঠিক তথ্য প্রদান করেছেন। ভুল তথ্যের কারণে কোনো সমস্যা হলে, তার দায়ভার আপনার উপর বর্তাবে।</p>

                <h4>✅ <strong>মূল্য এবং পেমেন্ট:</strong></h4>
                <p>পণ্যের মূল্য এবং পেমেন্ট পদ্ধতি ওয়েবসাইটে উল্লেখ করা হয়েছে। আমরা মূল্য পরিবর্তনের অধিকার সংরক্ষণ করি।</p>

                <h4>✅ <strong>ডেলিভারি:</strong></h4>
                <p>আমরা পণ্য ডেলিভারির জন্য নির্ধারিত সময়সীমা মেনে চলার চেষ্টা করি। তবে, কোনো কারণে ডেলিভারি বিলম্ব হলে, আমরা দুঃখিত থাকব কিন্তু এর জন্য আমরা দায়ী থাকব না।</p>

                <h4>✅ <strong>রিটার্ন এবং রিফান্ড:</strong></h4>
                <ul>
                    <li>পণ্যটি অবশ্যই ব্যবহারবিহীন, অক্ষত এবং মূল প্যাকেজিংয়ে থাকতে হবে।</li>
                    <li>প্রোডাক্টের সাথে দেওয়া উপহার বা এক্সট্রা আইটেম থাকলে সেগুলোও ফেরত দিতে হবে।</li>
                    <li>কাস্টমাইজড বা ব্যক্তিগত ব্যবহারের পণ্য (যেমনঃ ব্যবহৃত কসমেটিকস) রিটার্নযোগ্য নয়।</li>
                </ul>

                <h4>✅ <strong>গোপনীয়তা নীতি:</strong></h4>
                <p>আপনার ব্যক্তিগত তথ্য আমাদের কাছে নিরাপদ। আমরা আপনার তথ্য তৃতীয় পক্ষের সাথে শেয়ার করব না, যদি না এটি আইনি প্রয়োজন হয়।</p>

                <h4>✅ <strong>যোগাযোগ:</strong></h4>
                <p>যেকোনো প্রশ্ন বা সমস্যার জন্য আমাদের হটলাইন নম্বরে কল করুন বা ইমেইল করুন।</p>

                <p class="mt-5">আমাদের শর্তাবলী যেকোনো সময় পরিবর্তন করার অধিকার আমরা সংরক্ষণ করি।</p>
            </div>
        </div>
    </section>
@endsection
