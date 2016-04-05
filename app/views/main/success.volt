<html><head>
  <!-- Standard Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>???????|????? ???? ?????? ????</title>
  <link rel="stylesheet" type="text/css" href="/lib/semantic/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="/css/font.yekan.css">
  <link rel="shortcut icon" sizes="16x16" href="/img/icon-16.png">
  <link rel="shortcut icon" sizes="32x32" href="/img/icon-32.png">
  <script src="/lib/jquery/jquery.min.js"></script>
  <script src="/lib/semantic/semantic.min.js"></script>

  <style type="text/css">
    * {
      font-family: BYekan ;
    }
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>
</head>
<body>
  <div class="ui red inverted menu">
<div class="item">
    <img src="img/logo.png">
  ????? ??
  </div>

  <div class="item">

		<div class="ui icon button"><i class="home icon"></i>Home</div>
	</div>

    <div class="right item">
        <div class="ui simple dropdown item">
          <i class="user icon"></i>
          <span class="text">{{ full_name }}</span>
           <i class="dropdown icon"></i>
          <div class="menu">
          <div class="item" href="/login">???? ????></???>
      <div class="item" href="/category/list">???? ???? ??</div>
      <div class="item" href="/question/list">??????</div>
      <div class="item"  href="/category/create">????? ???? ???? ????</div>
  		<div class="item" href="/question/create">????? ???? ????</div>

  <div class="item" href="/login/logout"><i class="sign out icon"></i>????</div>
    </div>
    </div>
  </div></div>



  <div class="ui stripe community vertical segment"><a class="item">
	</a><div class="ui red two column center aligned divided very relaxed stackable grid container"><div class="row"><div class="column"><a class="item">
         	</a><div class="ui piled segment"><a class="item">
            	<h2 class="ui icon header">
               		<p>????? ?? ???? ?</p>
            	</h2>
            	<p>?? ???? ?????? ??? ???? ???????</p>
            	<p>:))))</p>
            	</a><a class="ui red large basic button button" href="/login"><p>???? ?? ????</p></a>
            </div>
             <div class="ui piled segment">
                 <h2 class="ui icon header">
                     <p>?????? ???? ???? ??</p>
                 </h2>
                 <p></p>
                 <a class="ui violet large basic button button" href="/category/create"><p>????? ???? ???? ????</p></a>
                 <a class="ui green large basic button button" href="/category/list"><p>???? ???? ??</p></a>
             </div>
             <div class="ui piled segment">
                 <h2 class="ui icon header">
                     <p>?????? ??????</p>
                 </h2>
                 <p></p>
                 <a class="ui pink large basic button button" href="/question/create"><p>????? ???? ????</p></a>
                 <a class="ui brown large basic button button" href="/question/list"><p>??????</p></a>
             </div>
         </div>

      </div>
      <div class="row">
      		<div class="ui vertical footer segment">
      			<div class="ui horizontal small divided link list">
        			<a class="item" href="#">?????? ?? ??</a>
        			<a class="item" href="#"><p>?????? ??</p></a>
        			<a class="item" href="#"><p>?????? ???????</p></a>
        			<a class="item" href="#"><p>????? ??? ???????</p></a>
      			</div>
   			</div>
   		</div>
	</div>



</div></body></html>