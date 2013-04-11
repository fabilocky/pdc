var quotes=new Array()

//cambiar las frases

quotes[0]=' <IFRAME style="width: 234px; height: 72px; vertical-align: top;" class="new" align="left" framespacing="0" border="0" cols="100%,*" frameborder="0" src="http://www.cotizacion-dolar.com.ar/recursos-webmaster/formal-cd/dolar_euro_234x90.php" scrolling="no" noresize>Su navegador no soporta el uso de frames.</IFRAME>'

var whichquote=Math.floor(Math.random()*(quotes.length))
document.write(quotes[whichquote])


