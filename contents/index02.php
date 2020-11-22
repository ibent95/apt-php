<script>
    var countDownDate_<?php echo $unique; ?> = new Date("<?php echo $expiration; ?>").getTime();
    var distance_<?php echo $unique; ?>;
    
    var x_<?php echo $unique; ?> = setInterval(function() {

        // Get todays date and time
        var now_<?php echo $unique; ?> = new Date().getTime();

        // Find the distance between now an the count down date
        distance_<?php echo $unique; ?> = countDownDate_<?php echo $unique; ?> - now_<?php echo $unique; ?>;

        // Time calculations for days, hours, minutes and seconds
        var days_<?php echo $unique; ?> = Math.floor(distance_<?php echo $unique; ?> / (1000 * 60 * 60 * 24));
        var hours_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60)) / (1000 * 60));
        var seconds_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("countDown-<?php echo $unique; ?>").innerHTML =
            days_<?php echo $unique; ?> + " Hari " +
            hours_<?php echo $unique; ?> + " Jam " +
            minutes_<?php echo $unique; ?> + " Menit " +
            seconds_<?php echo $unique; ?> + " Detik ";
        // console.log(distance);
        // If the count down is finished, write some text
        if (distance_<?php echo $unique; ?> <= 0) {
            clearInterval(x_<?php echo $unique; ?>);
            document.getElementById("countDown-<?php echo $unique; ?>").innerHTML = "Proccessing...";
            $.ajax({
                url: 'functions/function_responds.php?content=set_status_pemesanan',
                type: 'POST',
                dataType: 'html',
                async: false,
                data: {
                    id: '<?php echo $order['id_pemesanan']; ?>',
                    status_pemesanan: 'batal'
                },
            }).done(function() {
                console.log("success");
                window.location.replace('?content=profil');
            }).fail(function() {
                console.log("error");
            }).always(function() {
                console.log("complete");
            });
        }
    }, 1000);
    // console.log(distance);
</script>