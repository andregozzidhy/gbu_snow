$(window).load(function() {
	
	prepareData();
	
	<?php 
	for ($i = 1; $i <= count($kategori); $i++)
	{ ?>
		
		$(".kategori-each<?= $i ?>").mouseenter(function() {
			var line = $(".kategori-each-line<?= $i ?>");
			line.stop();
			line.animate({width: $(".kategori-each<?= $i ?>").css("width")}, 250);
		});
		
		$(".kategori-each<?= $i ?>").mouseleave(function() {
			var line = $(".kategori-each-line<?= $i ?>");
			line.stop();
			line.animate({width: '0px'}, 250);
		});
		
<?php }
	?>
	
	<?php 
	for ($i = 1; $i <= count($merek); $i++)
	{ ?>
		
		$(".merek-each<?= $i ?>").mouseenter(function() {
			var line = $(".merek-each-line<?= $i ?>");
			line.stop();
			line.animate({width: $(".merek-each<?= $i ?>").css("width")}, 250);
		});
		
		$(".merek-each<?= $i ?>").mouseleave(function() {
			var line = $(".merek-each-line<?= $i ?>");
			line.stop();
			line.animate({width: '0px'}, 250);
		});
		
<?php }
	?>
	
	$("#search-button-container").mouseenter(function() {
		$("#search-button-white").stop();
		$("#search-button-white").fadeIn(150);
	});
	
	$("#search-button-container").mouseleave(function() {
		$("#search-button-white").stop();
		$("#search-button-white").fadeOut(150);
	});
	
	$(".kategori-each").click(function() {
		$.ajax({
			method: "post",
			url: '<?= site_url("controller/products") ?>',
			data: {kategori: $(this).data("value")}
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}).done(function(result) {
			$("#body-mid").html(result);
			firstLoad();
			scrollTop();
		});
	});
	
	$(".merek-each").click(function() {
		$.ajax({
			method: "post",
			url: '<?= site_url("controller/products") ?>',
			data: {merek: $(this).data("value")}
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}).done(function(result) {
			$("#body-mid").html(result);
			firstLoad();
			scrollTop();
		});
	});
	
	$("#logout").click(function() {
		$.ajax({
			method: "post",
			url: '<?= site_url("controller/logout") ?>',
		}).fail(function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}).done(function(result) {
			window.location.reload();
		});
		
	});
	
});

function scrollTop()
{
	$("html, body").animate({
        scrollTop: 100
    }, 300);
}

function firstLoad()
{
	$(".content").each(function() {
		var obj = $(this);
		var timeout = setTimeout(function() {
			timeoutEnd(obj);
		}, Math.floor(Math.random()*400));
	});
}

function prepareData()
{
	firstLoad();
	loadLoginAjax();
}

function loadLoginAjax(dataUser = "", dataPass = "")
{
	$.ajax({
		method: "post",
		url: '<?= site_url("controller/login") ?>',
		data: {user: dataUser, pass: dataPass}
	}).fail(function(jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	}).done(function(result) {
		$("#loginModal").html(result);
	});
	
}

function timeoutEnd(obj)
{
	obj.fadeTo(400, 1, function() {
		
	});
}

function closeLoginModal()
{
	$("#loginModal").attr("class", "modal fade");
	$("#loginModal").attr("style", "display: none;");
	$(".modal-backdrop").remove();
}
