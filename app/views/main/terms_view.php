<style>
        .Terms-and-Conditions{
            padding-top:30px;
        }
        .Terms-and-Conditions p{
            color: #fff;
        }
        .Terms-and-Conditions .titlee {
            font-weight: bold;
            padding:  0 30px;

        }
        .Terms-and-Conditions  ul{
            list-style:circle;
            padding: 20px 50px ;

        }
        ul li{
            list-style:circle;
            margin: 30px 0;
        }

    </style>
    <div class="Terms-and-Conditions text-center">
        <h1 class="main-color"><?=$this->__("main.terms.terms")?></h1>
        <h3 class="terms-text"><?=$this->__("main.terms.welcome_terms")?></h3>
        <small class="terms-text"><?=$this->__("main.terms.serv")?></small>
        <ul class="terms-text text-<?=$this->__("settings.align")?>">
        <?=$this->terms_text?>
    </ul>
</div>