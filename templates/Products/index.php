<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bootstrap-tabs product-tabs">
                    <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                        <h3>Products</h3>
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">

                            <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4">
                                <?php foreach ($products as $product): ?>
                                <div class="col">
                                    <div class="product-item">
                                        <a href="#" class="btn-wishlist"><svg width="24" height="24"><use xlink:href="#heart"></use></svg></a>
                                        <figure>
                                            <a href="#" title="<?= h($product->name) ?>">
                                            <img src="<?= h($product->image) ?>"  class="<?= h($product->name) ?>">
                                            </a>
                                        </figure>
                                        <h3><?= h($product->name) ?></h3>
                                        <span class="qty"><?= $this->Number->format($product->quantity) ?> Unit</span><span class="rating"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> 4.5</span>
                                        <span class="price">E£<?= $this->Number->format($product->price , ['places' => 2 ]) ?></span>
                                        <div class="align-items-center justify-content-between ">
                                        <!--
                                            <div class="input-group product-qty">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                                    <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                                    </button>
                                                </span>
                                                <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                                        <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                                    </button>
                                                </span>
                                            </div>
                                        -->
                                            <div class="d-grid gap-2 mt-1">
                                                <a href="#"  @click.prevent='addToCart(<?= json_encode($product) ?>)' class="btn btn-outline-primary">Add to Cart <i class="fas fa-shopping-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- / product-grid -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


