<?php
class SessionManager
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        session_set_save_handler(
            [$this, 'open'],
            [$this, 'close'],
            [$this, 'read'],
            [$this, 'write'],
            [$this, 'destroy'],
            [$this, 'gc']
        );
        session_start();
    }

    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        return true; // Oturumu kapatırken bağlantıyı kapatma işlemi burada yapılmıyor
    }

    public function read($id)
    {
        $sql = "SELECT data FROM sessions WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($data);
        $stmt->fetch();
        $stmt->close();
        return $data ? $data : '';
    }

    public function write($id, $data)
    {
        $access = time();
        $sql = "REPLACE INTO sessions (id, access, data) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sis', $id, $access, $data);
        return $stmt->execute();
    }

    public function destroy($id)
    {
        $sql = "DELETE FROM sessions WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $id);
        return $stmt->execute();
    }

    public function gc($maxlifetime)
    {
        $old = time() - $maxlifetime;
        $sql = "DELETE FROM sessions WHERE access < ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $old);
        return $stmt->execute();
    }
}

// Oturum kontrol fonksiyonları
function checkAdminAccess()
{
    if ($_SESSION['user_type'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }
}

function checkStoreAccess()
{
    if ($_SESSION['user_type'] !== 'store') {
        header("Location: ../login.php");
        exit();
    }
}

function checkManagerAccess()
{
    if ($_SESSION['user_type'] !== 'manager') {
        header("Location: ../login.php");
        exit();
    }
}

// Veritabanı bağlantısını başlat
require 'config.php';
$sessionManager = new SessionManager($conn);
?>
