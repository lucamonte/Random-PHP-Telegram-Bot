<?php

include("dbconfig.php");

$api_token = "your_telegram_api_token";
$api_url = "https://api.telegram.org/bot" . $api_token;
$update = json_decode(file_get_contents('php://input'), TRUE);

$messageId = $update['message']['message_id'];
$chatId = $update['message']['from']['id'];
$name = $update['message']['chat']['first_name'];
$username = $update['message']['from']['username'];
$text = $update['message']['text'];
$language = $update['message']['from']['language_code'];

$customkeyboard = '["Scemo scemo"]';
$appendkeyboard = '&reply_markup={"keyboard"]:['.$customkeyboard.'],"resize_keyboard":true}';

$messages = array(
    "Ciao $name, io sono Daino e mi piacciono i treni!", 
    "Ma che cos'è la Coca Cola?", 
    "Ah davvero?", 
    "Dobby dobby", 
    "Dibby dibby", 
    "Oh $name, fermo, che ho la caviglia tanta!"
);

$pictures = array(
    "https://upload.wikimedia.org/wikipedia/commons/b/b6/ALe_582%2C_Stazione_di_Bologna_Centrale.JPG",
    "https://upload.wikimedia.org/wikipedia/commons/4/41/Trenord_Aln_668_3148%2BALn_668_3137_Ghedi_20121102.JPG",
    "https://upload.wikimedia.org/wikipedia/commons/b/be/FS_E656_294.jpg",
    "https://www.fotoferrovie.info/albums/userpics/10421/SDIT03_026.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/E.464.603_Asti.JPG/1200px-E.464.603_Asti.JPG"
);

switch($text){
    case "/daino":
        sendMessage($chatId, $messages[rand(0, sizeof($messages) - 1)]);
    break;
    case "/peter":
        sendPicture($chatId, $pictures[rand(0, sizeof($pictures) - 1)]);
    break;
    case "tg_api_info":
        sendMessage($chatId, json_encode($update, JSON_PRETTY_PRINT));
    break;
    case "/chatinfo":
        sendMessage($chatId, "<b>Chat ID</b>: $chatId\n<b>Username</b>: $GLOBALS[username]\n<b>Nome</b>: $name\n<b>Lingua</b>: $GLOBALS[language]");
    break;
    default: 
        sendMessage($chatId, "Ciao <b>$name</b>, digita \"/daino\" per iniziare!\nProva anche il comando \"/peter\"!");
    break;
}

function sendMessage($chatId, $text) {
    $url = $GLOBALS[api_url] . "/sendMessage?chat_id=$chatId&text=" . urlencode($text) . "&parse_mode=HTML";
    saveMessage($GLOBALS[messageId], $chatId, $GLOBALS[username], $GLOBALS[text]);
    file_get_contents($url);
}

function sendPicture($chatId, $picture) {
    $url = $GLOBALS[api_url] . "/sendPhoto?chat_id=$chatId&photo=" . urlencode($picture) . "&parse_mode=HTML";
    file_get_contents($url);
}

function saveMessage($messageId, $chatId, $username, $message) {
    $query = "INSERT INTO messages (id, chatid, username, messageText) VALUES ('$messageId', '$chatId', '$username', '$message')";
    mysqli_query($GLOBALS[link], $query);
}

?>
