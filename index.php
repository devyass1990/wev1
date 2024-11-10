<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تشفير وفك تشفير</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2em;
        }
        textarea, input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
        }
        button {
            background-color: #2575fc;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1a58b5;
        }
        .result {
            margin-top: 20px;
            font-weight: bold;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>تشفير وفك تشفير النصوص</h1>
        <form method="post">
            <textarea name="text" rows="4" placeholder="أدخل النص هنا"><?= isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '' ?></textarea>
            <select name="method">
                <option value="base64" <?= isset($_POST['method']) && $_POST['method'] == 'base64' ? 'selected' : '' ?>>Base64</option>
                <option value="caesar" <?= isset($_POST['method']) && $_POST['method'] == 'caesar' ? 'selected' : '' ?>>Caesar Cipher</option>
            </select>
            <input type="number" name="shift" placeholder="Shift (للقيصر فقط)" value="<?= isset($_POST['shift']) ? htmlspecialchars($_POST['shift']) : '' ?>" />
            <select name="operation">
                <option value="encode" <?= isset($_POST['operation']) && $_POST['operation'] == 'encode' ? 'selected' : '' ?>>تشفير</option>
                <option value="decode" <?= isset($_POST['operation']) && $_POST['operation'] == 'decode' ? 'selected' : '' ?>>فك التشفير</option>
            </select>
            <button type="submit">تنفيذ</button>
        </form>
        <div class="result">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $text = $_POST['text'];
                    $method = $_POST['method'];
                    $operation = $_POST['operation'];
                    
                    function caesar_cipher($text, $shift, $decrypt = false) {
                        if ($decrypt) {
                            $shift = -$shift;
                        }
                        $result = '';
                        foreach (str_split($text) as $char) {
                            if (ctype_alpha($char)) {
                                $shift_amount = ctype_upper($char) ? 65 : 97;
                                $result .= chr((ord($char) + $shift - $shift_amount) % 26 + $shift_amount);
                            } else {
                                $result .= $char;
                            }
                        }
                        return $result;
                    }

                    if ($method == 'base64') {
                        if ($operation == 'encode') {
                            echo base64_encode($text);
                        } else {
                            echo base64_decode($text);
                        }
                    } elseif ($method == 'caesar') {
                        $shift = intval($_POST['shift']);
                        if ($operation == 'encode') {
                            echo caesar_cipher($text, $shift);
                        } else {
                            echo caesar_cipher($text, $shift, true);
                        }
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
