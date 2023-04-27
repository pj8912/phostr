<?php
// onload create a anonymous account with key-pair
// on click 'Import Key' take a user private key, reload window and generate account wrt that private key
?>
Import Key
<br>
<br>
If You already have a private key import <br>
<br>

<input type="text" id="private_key" placeholder="PrivateKey(nsec)"><br>
<button id="import" type="button"> Import Key</button>


<script>
    function accountKeys() {
        fetch('keys.php')
            .then(res => res.json())
            .then(response => {
                console.log(response)
                let checkNostrData = localStorage.getItem("userNostrData")
                if (checkNostrData == null) {
                    const userNostrData = {
                        "keys": {
                            "public_key": response.public_key,
                            "private_key": response.private_key
                        }
                    }
                    localStorage.setItem("userNostrData", JSON.stringify(userNostrData));
                }
            })
            .catch(err => console.log(err))
    }
    let checkNostrData = localStorage.getItem("userNostrData")
    if (checkNostrData !== null) {
        console.log(JSON.parse(checkNostrData));
        console.log('')
        console.log(JSON.parse(checkNostrData).keys['private_key']);
        console.log(JSON.parse(checkNostrData).keys['public_key']);
    } else {
        accountKeys();
    }

    function importKey() {

        const private_key = document.getElementById('private_key');

        fetch('import_key.php', {
                method: "POST",
                body: JSON.stringify({
                    "input_private_key": private_key.value
                })
            })
            .then(res => res.json())
            .then(response => {
                console.log(`
               |----------YOUR ACCOUNT-----------------------------------------------------------|
               | PUBLIC KEY :  ${response.publickey}     |
               | PRIVATE KEY: ${response.privatekey}     |
               |---------------------------------------------------------------------------------|`)
        })
            .catch(err => console.log('err:' + err))
            private_key.value='';

    }

    document.getElementById('import').onclick =() =>{
        window.location.reload
        importKey()
    }
</script>