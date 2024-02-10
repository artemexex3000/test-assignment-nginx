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
<div class="hero min-h-screen bg-base-200">
    <div class="hero-content text-center flex">
        <div class="max-w-md">
            <div class="mockup-browser">
                <div id="linkCardGrid"></div>
                <div>
                    <button id="loadMoreButton" class="btn">Show next</button>
                </div>
                <div class="max-w-md">
                    <a href="/">
                        <button class="btn">Home</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (async () => {
        const linkCardGrid = document.getElementById('linkCardGrid');
        const loadMoreButton = document.getElementById('loadMoreButton');

        let page = 0;

        const loadLinks = async () => {
            const paginatedUrl = `https://test-assignment-nginx.fly.dev/api/v1/users?page=${page}&count=6`;

            const {users} = await fetch(paginatedUrl, {
                method: 'GET',
                headers: {
                    Accept: 'application/json'
                },
            }).then((res) => {
                return res.json()
            });

            const htmlString = users
                .map(
                    (user) => `
                        <div class="card w-50 bg-base-100 shadow-xl mb-3">
                            <figure class="px-10 pt-10">
                                <div class="avatar">
                                    <div class="w-24 rounded">
                                        <img src="${user.photo}" alt="Photo err" />
                                    </div>
                                </div>
                            </figure>
                            <div class="card-body items-center text-center">
                                <p>${user.name}</p>
                            </div>
                            <div class="card-body items-center text-center">
                                <p>${user.position.name}</p>
                            </div>
                            <div class="card-body items-center text-center">
                                <p>${user.phone}</p>
                            </div>
                        </div>`
                ).join('');
            if (linkCardGrid) {
                linkCardGrid.innerHTML += htmlString
            }
        }

        loadMoreButton.addEventListener('click', async () => {
            page++;
            await loadLinks();
        });
    })();
</script>
</body>
</html>
