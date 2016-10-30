@extends('layouts.app')

@section('content')
    <div class="page">


    </div>
    <script src="/js/lightbox-plus-jquery.min.js"></script>
    <script>
        $(".fb_1").on({
            "mouseover" : function() {
                this.src = '/images/_0006_icon-fb-hover.png';
            },
            "mouseout" : function() {
                this.src='/images/_0010_icon-fb.png';
            }
        });
        $(".in_1").on({
            "mouseover" : function() {
                this.src = '/images/_0005_icon-inst-hover.png';
            },
            "mouseout" : function() {
                this.src='/images/_0009_icon-inst.png';
            }
        });
        $(".fb_2").on({
            "mouseover" : function() {
                this.src = '/images/_0010_icon-fb.png';
            },
            "mouseout" : function() {
                this.src='/images/_0008_icon-fb-footer.png';
            }
        });
        $(".in_2").on({
            "mouseover" : function() {
                this.src = '/images/_0009_icon-inst.png';
            },
            "mouseout" : function() {
                this.src='/images/_0007_icon-inst-footer.png';
            }
        });
    </script>
    <script src="/js/swiper.min.js"></script>
    <!-- Initialize Swiper -->
@endsection