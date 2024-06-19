<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="storage/images/dlc-logo1.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
     <link rel="icon" href="storage/image/dlc-logo1.png" type="image/png">
    <title>E-Val-Admin</title>
</head>
<style>
    body {
        position: relative; /* Required for the ::before pseudo-element */
        overflow: hidden; /* Prevents scrollbars when the blur is applied */
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-image: url('storage/images/index-bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        filter: blur(8px); /* Adjust the blur amount as needed */
        z-index: -1; /* Ensures the pseudo-element is behind all other content */
        opacity: 0.5; /* Adjust the background image opacity as needed */
    }
    form {
    background-color: rgba(255, 255, 255, 0.5); /* Adjust the opacity by changing the last parameter */
}

</style>
<body class="">
    <x-messages/>
    

    <div class="max-w-md mx-auto py-10 px-4" id="AdminLogin">
        
        <form action="{{ route('registerAdmin')}}" method="POST" class=" shadow-md rounded px-8 pt-3 pb-8 mb-4">
            <h1 class="text-lg text-center font-bold mb-1">Register Admin</h1>
            @csrf
           
            <div class="mb-4">
                <label for="admin_id" class="block text-gray-900 text-sm font-bold mb-2">Admin ID</label>
                <input type="number" id="admin_id" name="admin_id" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="firstname" class="block text-gray-900 text-sm font-bold mb-2">First name</label>
                <input type="text" id="firstname" name="firstname" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="lastname" class="block text-gray-900 text-sm font-bold mb-2">Last name</label>
                <input type="text" id="lastname" name="lastname" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-900 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-900 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-900 text-sm font-bold mb-2">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('error')
                    <p class="text-red-500 text-sm text-end p-1">
                        {{$message}}
                    </p>
                @enderror
            </div>
    
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-red-900 hover:bg-red-800 text-white font-bold py-2 px-4 mx-auto rounded focus:outline-none focus:shadow-outline w-full">
                    Register
                </button>
            </div>
            
        </form>

    </div>

   
    


</body>
</html>