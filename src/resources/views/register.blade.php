<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crop Image</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col items-center">
<div class="mockup-browser">
    <div class="flex justify-center px-4 py-10">
        <form enctype="multipart/form-data" method="post">
            <p class="flex justify-left px-4">Name</p>
            <label for="name" class="flex justify-center px-4 py-6">
                <input type="text" name="name" id="name" placeholder="name"
                       class="input input-bordered w-full max-w-xs"/>
            </label>

            <p class="flex justify-left px-4">Email</p>
            <label for="email" class="flex justify-center px-4 py-6">
                <input type="text" name="email" id="email" placeholder="email"
                       class="input input-bordered w-full max-w-xs"/>
            </label>

            <p class="flex justify-left px-4">Phone</p>
            <label for="phone" class="flex justify-center px-4 py-6">
                <input type="text" name="phone" id="phone" placeholder="phone"
                       class="input input-bordered w-full max-w-xs"/>
            </label>

            <p class="flex justify-left px-4">Photo</p>
            <label for="photo" class="flex justify-center px-4 py-6">
                <input type="file" name="photo" id="photo" class="file-input w-full max-w-xs"/>
            </label>

            <p class="flex justify-left px-4">Position</p>

            <label for="position_id" class="flex justify-center px-4 py-6 rounded-box">
                <select name="position_id" id="position_id" class="select select-bordered w-full max-w-xs">
                    <option disabled selected>Pick your position</option>
                </select>
            </label>

            <label for="submit" class="flex justify-center px-4 py-6">
                <input placeholder="Submit" name="submit" id="submit" class="btn flex justify-center">
            </label>
        </form>
    </div>
    <div class="max-w-md flex justify-center">
        <a href="/"><button class="btn">Home</button></a>
    </div>
</div>
<script>
    (async () => {
        const formData = new FormData();

        const arrayOfPositions = (async () => {
            const positionsValue = await fetch('http://127.0.0.1:8000/api/v1/positions/')
                .then(res => res.json());

            return positionsValue.positions;
        });

        await (async () => {
            const positions = await arrayOfPositions();
            const dropdownSelector = document.getElementById('position_id');

            for (position of positions) {
                const newOption = document.createElement("option");
                newOption.value = position.id;
                newOption.text = position.name;

                dropdownSelector.add(newOption);
            }
        })();

        // console.log(document.querySelector('#position_id').options[document.querySelector('#position_id').options.selectedIndex].value);

        const token = async function () {
            const tokenValue = await fetch('http://127.0.0.1:8000/api/v1/token')
                .then(res => res.json())
                .catch(error => {
                    console.error(error)
                });

            return tokenValue.token;
        };

        const store = (async () => {
            formData.append('name', document.querySelector('#name').value);
            formData.append('email', document.querySelector('#email').value);
            formData.append('phone', document.querySelector('#phone').value);
            formData.append('photo', document.querySelector('input[type="file"]').files[0]);
            formData.append('position_id', document.querySelector('#position_id').options[document.querySelector('#position_id').options.selectedIndex].value);

            await fetch('http://127.0.0.1:8000/api/v1/users/', {
                method: 'POST',
                redirect: 'follow',
                headers: {
                    Authorization: 'Bearer'.concat(' ', await token()),
                    Accept: 'application/json'
                },
                body: formData
            }).then(async res => {
                const data = await res.json();

                if (data.success) {
                    alert(data.message);
                    window.location.assign('/');
                } else {
                    let error = 'Validation failed:';

                    for (const key in data.fails) {
                        error = error + (`\n\n${data.fails[key]}`);
                    }

                    alert(error);
                }
            })
        });

        document.getElementById('submit').onclick = async () => {
            await store();
        }
    })();
</script>
</body>
</html>
