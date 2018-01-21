<?php
/*
Template Name: Elements
*/
?>
<?php get_header(); ?>
<main id="content">
    <section class="elements-banner">
            <div class="container">
                <h2>Tutorials Kit</h2>
                <h4>Нашите компоненти:</h4>
            </div>
            </section>
            <section class="elements-wrapper">
                <div class="container">
                    <section class="elements-buttons">
                        <h4 class="elements-heading">Основни бутони:</h4>
                        <div class="button-content">
                            <p>По цвят:</p>
                            <button class="btn btn-primary">Primary</button>
                            <button class="btn btn-default">Default</button>
                            <button class="btn btn-info">Info</button>
                            <button class="btn btn-warning">Warning</button>
                            <button class="btn btn-danger">Danger</button>
                            <button class="btn btn-success">Success</button>
                            <p>По размер:</p>
                            <button class="btn btn-primary btn-xs">x-small</button>
                            <button class="btn btn-primary btn-sm">small</button>
                            <button class="btn btn-primary">normal</button>
                            <button class="btn btn-primary btn-lg">large</button>
                            <p>По форма:</p>
                            <button class="btn btn-primary">Normal</button>
                            <button class="btn btn-primary btn-round">Rounded</button>
                            <button class="btn btn-primary btn-curcle">C</button>
                        </div>
                    </section>
                    <section class="elements-texts">
                        <h4 class="elements-heading">Основни текстове:</h4>
                        <div class="heading-content">
                            <div class="typography-box"><h1>Heading one</h1></div>
                            <div class="typography-box"><h2>Heading two</h2></div>
                            <div class="typography-box"><h3>Heading three</h3></div>
                            <div class="typography-box"><h4>Heading four</h4></div>
                            <div class="typography-box"><h1 class="title">Heading one Title</h1></div>
                            <div class="typography-box"><h2 class="title">Heading two Title</h2></div>
                            <div class="typography-box"><h3 class="title">Heading three Title</h3></div>
                            <div class="typography-box"><h4 class="title">Heading four Title</h4></div>
                            <div class="typography-box">
                                <p>Paragraph:<br>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div>
                        </div>
                    </section>
                    <section class="elements-forms">
                        <h4 class="elements-heading">Основни Форми:</h4>
                        <div class="forms-content row">
                            <label class="col-sm-4">
                            <input type="text-default" value="" placeholder="Regular" class="form-control">
                            </label>
                            <label class="col-sm-4">
                            <input type="text-success" value="" placeholder="Success" class="form-control">
                            <span><i class="fa fa-check"></i></span>
                            </label>
                            </label>
                            <label class="col-sm-4">
                            <input type="text-error" value="" placeholder="Error" class="form-control">
                            <span><i class="fa fa-close"></i></span>
                            </label>
                            <label class="col-sm-5">
                            <textarea class="form-control" rows="7" placeholder="Message"></textarea>
                            </label>

                        </div>
                    </section>
</main>
        
<?php get_footer(); ?>
