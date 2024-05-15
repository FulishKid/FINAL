<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            width: 300px;
        }
        form:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
            margin-right: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 auto;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            form.onsubmit = function (event) {
                const password = document.getElementById("password").value;
                const confirmation = document.getElementById("password_confirmation").value;
                if (password !== confirmation) {
                    alert("The passwords do not match. Please enter matching passwords.");
                    event.preventDefault();
                }
            };
        });
    </script>
</head>
<body>
<h1>Reset Your Password</h1>
<form method="POST" action="{{ url('api/reset-password-submit') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" required minlength="8">
    <label for="password_confirmation">Confirm New Password:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" >
    <button type="submit">Submit</button>
</form>
</body>
</html>
