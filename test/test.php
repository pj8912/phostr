<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/dd021511bc.js" crossorigin="anonymous"></script>



<div class="container">

    <div class="card card-body col-md-6 m-auto mt-5">
        <div style="display:flex; flex-direction:row">

            <h3>
                Your Account
            </h3>
            <button class="btn btn-primary btn-sm rounded-5" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: auto;"><i class="fas fa-key"></i> Import Private Key</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Import Private Key</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2"><input type="text" class="form-control" id="private_key" placeholder="PrivateKey(nsec)"></div>

                            <button id="import" class="btn btn-primary" type="button"> Import Key</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div id="profile-info">
        </div>
    </div>
</div>

<script>
    document.onreadystatechange = function() {
        if (document.readyState == "interactive") {

            document.getElementById('import').addEventListener("click", importKey)

            if (localStorage.getItem("userNostrData") === null) {
                fetch('keys.php')
                    .then(res => res.json())
                    .then(response => {
                        console.log(response)
                        const userNostrData = {
                            "keys": {
                                "public_key": response.public_key,
                                "private_key": response.private_key
                            }
                        }
                        localStorage.setItem("userNostrData", JSON.stringify(userNostrData));
                        let nostrData = localStorage.getItem("userNostrData")
                       let op = `Public Key: ${JSON.parse(nostrData).keys['public_key']}<br>Private Key: ${JSON.parse(nostrData).keys['private_key']}`

                        document.getElementById('profile-info').innerHTML =op;

                    })
                    .catch(err => console.log(err))
            } else {
                let checkNostrData = localStorage.getItem("userNostrData")
                let op = `Public Key: ${JSON.parse(checkNostrData).keys['public_key']}<br>Private Key: ${JSON.parse(checkNostrData).keys['private_key']}`
                document.getElementById('profile-info').innerHTML =op;
                // console.log(JSON.parse(checkNostrData));
                // console.log(JSON.parse(checkNostrData).keys['private_key']);
                // console.log(JSON.parse(checkNostrData).keys['public_key']);
            }

            function importKey() {
                localStorage.clear()
                const private_key = document.getElementById('private_key');

                fetch('import_key.php', {
                        method: "POST",
                        body: JSON.stringify({
                            "input_private_key": private_key.value
                        })
                    })
                    .then(res => res.json())
                    .then(response => {
                        const userNostrData = {
                            "keys": {
                                "public_key": response.publickey,
                                "private_key": response.privatekey
                            }
                        }
                        localStorage.setItem("userNostrData", JSON.stringify(userNostrData));
                        let checkNostrData = localStorage.getItem("userNostrData")
                        console.log('new private key: ' + JSON.parse(checkNostrData).keys['private_key']);
                        console.log('new public key: ' + JSON.parse(checkNostrData).keys['public_key']);
                        let op = `Public Key: ${JSON.parse(checkNostrData).keys['public_key']}<br>Private Key: ${JSON.parse(checkNostrData).keys['private_key']}`
                    })

                    .catch(err => console.log('err:' + err))
                private_key.value = '';
                location.reload()
            }
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>