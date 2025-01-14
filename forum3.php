
<?php
    session_start();
    include "koneksi.php";
    require 'koneksi.php'; // File koneksi database
    $defaultPhoto = "https://cdn.tailgrids.com/2.2/assets/core-components/images/account-dropdowns/image-1.jpg";

    $username = $_SESSION['username'];

// Gunakan prepared statement dengan placeholder `?`
$query = $conn->prepare("SELECT photo FROM users WHERE username = ?");
if ($query === false) {
    die("Kesalahan dalam query: " . $conn->error);
}

// Ikat parameter dan eksekusi query
$query->bind_param("s", $username); // "s" untuk string
$query->execute();

// Ambil hasil query
$result = $query->get_result();
if ($result->num_rows > 0) {
    $account = $result->fetch_assoc();

    // Periksa apakah kolom `photo` berisi data
    if (!empty($account['photo'])) {
        $photoBase64 = base64_encode($account['photo']); // Encode gambar ke base64

        // Simpan foto ke dalam session
        $_SESSION['photo'] = $photoBase64;
    } else {
        $_SESSION['photo'] = null; // Atur ke null jika foto kosong
    }
} else {
    echo "Data pengguna tidak ditemukan.";
}

// Tutup statement dan koneksi
$query->close();
$conn->close();
?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Sambat Rakyat</title>
        <link rel="shortcut icon" href="images/samblog.svg">
        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
        <!-- font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/output.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/alpinejs" defer></script>
    </head>

    <body>  
        <!-- NAVBAR -->
        <?php
            if(isset($_GET['status'])) {
        ?>
            <script type="text/javascript">
                $("#successmodalclear").modal();
            </script>
        <?php
            }
        ?>
        <?php
            function isActive($page) {
                return basename($_SERVER['PHP_SELF']) == $page ? 'text-[#3E7D60] font-semibold' : 'text-gray-800 m-2';
            }
        ?>

        <div class="w-full bg-white shadow-lg p-5 flex justify-between items-center z-[100]">
            <!-- Logo and Title Section -->
            <div class="flex items-center ml-14">
                <a href="/">
                    <img src="images/samblog.svg" alt="Logo Sambat" class="h-[3vw] transition duration-300 transform hover:scale-110">
                </a>
                <div class="text-2xl font-bold ml-3">
                    <h1 class="text-[#3E7D60] hover:text-[#2C6B50] transition-colors duration-300">Sambat Rakyat</h1>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-center">
                <a href="index" class="<?= isActive('index.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Home</a>
                <a href="lapor" class="<?= isActive('lapor.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Sambat</a>
                <a href="lihat" class="<?= isActive('lihat.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Lihat Sambatan</a>
                <a href="community" class="<?= isActive('community.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Komunitas</a>
                <a href="faq" class="<?= isActive('faq.php') ?> no-underline text-primary hover:text-[#3E7D60] transition duration-300 font-semibold">Tentang</a>
            </div>
            <?php $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
                $email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
                
                ?>

                <!-- User Authentication Section -->
                <div class="flex items-center space-x-6">
                    <?php if ($username): ?>
                        <!-- Account Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-[#3E7D60] font-semibold transition">
                            <?php if (!empty($_SESSION['photo'])): ?>
                            <!-- Tampilkan gambar pengguna jika sudah diunggah -->
                            <img src="data:image/jpeg;base64,<?php echo $_SESSION['photo']; ?>" 
                                alt="User Avatar" 
                                class="w-8 h-8 rounded-full object-cover">
                        <?php else: ?>
                            <!-- Tampilkan gambar default jika pengguna belum mengunggah foto -->
                            <img src="<?php echo $defaultPhoto; ?>" 
                                alt="Default Avatar" 
                                class="w-8 h-8 rounded-full">
                        <?php endif; ?>
                            <span><?php echo htmlspecialchars($username); ?></span>
                            <svg class="w-5 h-5 transform" :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                                
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <p class="font-semibold"><?php echo htmlspecialchars($username); ?></p>
                                    <p class="text-gray-500"><?php echo htmlspecialchars($email); ?></p>
                                </div>
                                <a href="/SAMBATRAKYAT/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Lihat Profil</a>
                                <a href="/SAMBATRAKYAT/logout.php" class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100 transition">Log Out</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Login and Register Buttons -->
                        <a href="/SAMBATRAKYAT/login.php">
                            <button class="rounded-md font-semibold px-6 py-2 text-primary bg-white border hover:bg-gray-100 hover:underline transition">Masuk</button>
                        </a>
                        <a href="/SAMBATRAKYAT/signin.php">
                            <button class="rounded-md font-semibold px-6 py-2 text-white bg-[#3E7D60] hover:bg-[#5C8D73] transition">Daftar</button>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

        <!-- Mobile Menu Toggle Button -->
        <div class="md:hidden flex items-center space-x-4">
            <button class="text-gray-800 p-2 rounded-md hover:text-[#3E7D60] focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        

        <section 
        style="background-image: url('images/backbms.png');" 
        class="relative h-[60vh] bg-cover w-full bg-center bg-no-repeat flex items-center justify-center">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
        <!-- Content -->
        <div class="relative text-center text-white px-6 md:px-0">
            <h1 class="text-[40px] md:text-[60px] font-bold leading-tight">
                Keamanan 
            </h1>
            <p class="text-[18px] md:text-[24px] font-medium mt-4">
                Berdiskusi dengan komunitas mengenai topik-topik yang berkembang di masyarakat
            </p>
        </div>
    </section>

    <section class="h-auto w-full bg-gray-100 py-10" id="roomchat">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Forum Diskusi: Keamanan</h2>
        <div id="chat-container" class="bg-white min-h-[50vh] shadow-md rounded-lg p-6 overflow-y-auto max-h-[500px]">
            <!-- Chat akan dimuat di sini -->
        </div>

        <form id="chat-form" method="POST" class="mt-4 flex items-center space-x-4">
    <input 
        type="text" 
        id="chat-input" 
        name="chat" 
        placeholder="Ketik pesan Anda..." 
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-green-300" 
    />
    <button 
        type="submit" 
        name="submit"
        class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition"
    >
        Kirim
    </button>
</form>

    </div>
</section>
</body>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const chatContainer = document.getElementById("chat-container");
    const chatForm = document.getElementById("chat-form");
    const chatInput = document.getElementById("chat-input");

    // Load chat dari server
    function loadChat() {
        fetch("load_chat3.php")
            .then((response) => response.json())
            .then((chats) => {
                chatContainer.innerHTML = chats.map((chat) => `
                    <div class="mb-3">
                        <p class="text-gray-800 font-semibold">${chat.username}</p>
                        <p class="text-gray-700">${chat.chat}</p>
                        <small class="text-gray-500">${new Date(chat.waktu).toLocaleString()}</small>
                    </div>
                `).join("");
                chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll otomatis ke bawah
            })
            .catch((error) => console.error("Error loading chat:", error));
    }

    // Kirim chat
    chatForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const chat = chatInput.value.trim();
        if (!chat) return;

        fetch("proses_chat3.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ chat }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    chatInput.value = "";
                    loadChat(); // Perbarui chat
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => console.error("Error sending chat:", error));
    });

    // Load chat pertama kali
    loadChat();
    setInterval(loadChat, 5000); // Perbarui chat setiap 5 detik
});
</script>

</html>

