@extends('user.layout')
@section('noidung')
    <!-- Breadcrumb Begin -->
        <div class="breadcrumb-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__links">
                            <a href="/"><i class="fa fa-home"></i> Home</a>
                            <!-- <a href="#">Women’s </a> -->
                            <span>{{ $sp->ten_sp }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Product Details Section Begin -->
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="product__details__pic">
                            <!-- <div class="product__details__pic__left product__thumb nice-scroll">
                                <a class="pt active" href="#product-1">
                                    <img src="img/product/details/thumb-1.jpg" alt="">
                                </a>
                                <a class="pt" href="#product-2">
                                    <img src="img/product/details/thumb-2.jpg" alt="">
                                </a>
                                <a class="pt" href="#product-3">
                                    <img src="img/product/details/thumb-3.jpg" alt="">
                                </a>
                                <a class="pt" href="#product-4">
                                    <img src="img/product/details/thumb-4.jpg" alt="">
                                </a>
                            </div> -->
                            <div class="product__details__slider__content">
                                <div class="product__details__pic__slider owl-carousel">
                                    <img data-hash="product-1" class="product__big__img h-100 w-100" src="{{asset('/uploads/product/'.$sp->hinh)}}" alt="">
                                    <!-- <img data-hash="product-2" class="product__big__img" src="img/product/details/product-3.jpg" alt="">
                                    <img data-hash="product-3" class="product__big__img" src="img/product/details/product-2.jpg" alt="">
                                    <img data-hash="product-4" class="product__big__img" src="img/product/details/product-4.jpg" alt=""> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <form id="addToCartForm" action="{{ route('cart.add_cart', ['id' => $sp->id]) }}" method="POST">
                            @csrf
                            <div class="product__details__text">
                                <h3>{{ $sp->ten_sp }}</h3>
                                <div class="rating">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    <span>(138 reviews)</span>
                                </div>
                                <div class="product__details__price">
                                    {{ number_format($sp->gia_km, 0, ",", ".") }} VNĐ
                                    <span>{{ number_format($sp->gia, 0, ",", ".") }} VNĐ</span>
                                </div>

                                <div class="product__details__button">
                                    <div class="quantity">
                                        <span>Quantity:</span>
                                        <div class="pro-qty">
                                            <input type="number" name="soluong" id="soluong" value="1" min="1">
                                        </div>
                                    </div>
                                    <button class="btn btn-danger m-1" id="addtocartbtn" type="submit">Add to cart</button>
                                </div>

                                <div class="product__details__widget">
                                    <ul>
                                        <li>
                                            <span>Availability:</span>
                                            <div class="stock__checkbox">
                                                <label for="stockin">
                                                    In Stock
                                                    <input type="checkbox" id="stockin">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </li>

                                        <li>
                                            <span>Available size:</span>
                                            <div class="size__btn">
                                                @foreach ($size as $ssl)
                                                    <label for="size-{{ $loop->index }}">
                                                        <input name="size" value="{{ $ssl->size_product }}" type="radio" id="size-{{ $loop->index }}">
                                                        {{ $ssl->size_product }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <div id="errorMessage" style="color: #ff424f; display: none;">Vui lòng chọn Size</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const form = document.getElementById('addToCartForm');
                            const errorMessage = document.getElementById('errorMessage');

                            form.addEventListener('submit', function (event) {
                                const sizeSelected = document.querySelector('input[name="size"]:checked');
                                
                                if (!sizeSelected) {
                                    event.preventDefault(); // Chặn gửi form
                                    errorMessage.style.display = 'block'; // Hiện thông báo lỗi
                                } else {
                                    errorMessage.style.display = 'none'; // Ẩn thông báo nếu đã chọn
                                }
                            });
                        });
                        </script>
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <h6>Description</h6>
                                    <p>{{ $sp->mo_ta_ct }}</p>
                                </div>
                                <div class="tab-pane" id="tabs-2" role="tabpanel">
                                    <h6>Specification</h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                        quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                        Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                        voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                        consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                        dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                                </div>
                                <div class="tab-pane" id="tabs-3" role="tabpanel">
                                    <h6>Reviews ( 2 )</h6>
                                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                        quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                        Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                        voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                        consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                        dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="related__title">
                            <h5>RELATED PRODUCTS</h5>
                        </div>
                    </div>
                    @foreach($splienquan_arr as $splq)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('/uploads/product/'.$splq->hinh)}}">
                                    <!-- <div class="label new">New</div> -->
                                    <!-- <ul class="product__hover">
                                        <li><a href="img/product/related/rp-1.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                                        <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                        <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                    </ul> -->
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="/detail/product/{{ $splq->id }}">{{$splq->ten_sp}}</a></h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">{{number_format($splq->gia_km ? $splq->gia_km : $splq->gia,0,",",".")}} VNĐ</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Product Details Section End -->

@endsection