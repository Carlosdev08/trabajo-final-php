<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Helpers;
use App\Models\UserData;
use App\Models\Cita;
use App\Models\Noticia;
use Core\DB;

class DashboardController extends Controller
{
    private function checkAdmin(): bool
    {
        $auth = Session::get('auth');
        if (!$auth || $auth['rol'] !== 'admin') {
            $this->redirect(Helpers::baseUrl('/login'));
            return false;
        }
        return true;
    }

    public function index(): string
    {
        if (!$this->checkAdmin())
            return '';

        // Estadísticas generales
        $stats = $this->getGeneralStats();

        // Datos para gráficos
        $chartData = $this->getChartData();

        // Actividad reciente
        $recentActivity = $this->getRecentActivity();

        // Próximas citas
        $upcomingCitas = $this->getUpcomingCitas();

        return $this->view('admin/dashboard', [
            'title' => 'Dashboard Administrativo',
            'stats' => $stats,
            'chartData' => $chartData,
            'recentActivity' => $recentActivity,
            'upcomingCitas' => $upcomingCitas
        ]);
    }

    private function getGeneralStats(): array
    {
        $pdo = DB::pdo();

        // Total usuarios
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users_data");
        $totalUsers = $stmt->fetch()['total'];

        // Usuarios nuevos este mes
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users_data WHERE DATE(created_at) >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
        $newUsersThisMonth = $stmt->fetch()['total'] ?? 0;

        // Total citas
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM citas");
        $totalCitas = $stmt->fetch()['total'];

        // Citas pendientes
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM citas WHERE fecha_cita >= CURDATE()");
        $citasPendientes = $stmt->fetch()['total'];

        // Total noticias
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM noticias");
        $totalNoticias = $stmt->fetch()['total'];

        // Noticias este mes
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM noticias WHERE DATE(fecha) >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
        $noticiasThisMonth = $stmt->fetch()['total'] ?? 0;

        return [
            'totalUsers' => $totalUsers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'totalCitas' => $totalCitas,
            'citasPendientes' => $citasPendientes,
            'totalNoticias' => $totalNoticias,
            'noticiasThisMonth' => $noticiasThisMonth
        ];
    }

    private function getChartData(): array
    {
        $pdo = DB::pdo();

        // Citas por mes (últimos 6 meses)
        $stmt = $pdo->query("
            SELECT 
                DATE_FORMAT(fecha_cita, '%Y-%m') as mes,
                COUNT(*) as total
            FROM citas 
            WHERE fecha_cita >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(fecha_cita, '%Y-%m')
            ORDER BY mes
        ");
        $citasPorMes = $stmt->fetchAll();

        // Usuarios por rol
        $stmt = $pdo->query("
            SELECT rol, COUNT(*) as total 
            FROM users_login 
            GROUP BY rol
        ");
        $usuariosPorRol = $stmt->fetchAll();

        return [
            'citasPorMes' => $citasPorMes,
            'usuariosPorRol' => $usuariosPorRol
        ];
    }

    private function getRecentActivity(): array
    {
        $pdo = DB::pdo();

        // Últimas 10 actividades (simplificado)
        $activities = [];

        // Últimas citas creadas
        $stmt = $pdo->query("
            SELECT 
                c.idCita,
                c.fecha_cita,
                c.created_at,
                CONCAT(ud.nombre, ' ', ud.apellidos) as usuario,
                'cita_creada' as tipo
            FROM citas c
            JOIN users_data ud ON c.idUser = ud.idUser
            ORDER BY c.idCita DESC
            LIMIT 5
        ");
        $recentCitas = $stmt->fetchAll();

        // Últimas noticias creadas  
        $stmt = $pdo->query("
            SELECT 
                n.idNoticia,
                n.titulo,
                n.fecha,
                CONCAT(ud.nombre, ' ', ud.apellidos) as autor,
                'noticia_creada' as tipo
            FROM noticias n
            JOIN users_data ud ON n.idUser = ud.idUser
            ORDER BY n.idNoticia DESC
            LIMIT 5
        ");
        $recentNoticias = $stmt->fetchAll();

        return [
            'citas' => $recentCitas,
            'noticias' => $recentNoticias
        ];
    }

    private function getUpcomingCitas(): array
    {
        $pdo = DB::pdo();

        $stmt = $pdo->query("
            SELECT 
                c.*,
                CONCAT(ud.nombre, ' ', ud.apellidos) as usuario,
                ud.telefono
            FROM citas c
            JOIN users_data ud ON c.idUser = ud.idUser
            WHERE c.fecha_cita >= CURDATE()
            ORDER BY c.fecha_cita ASC
            LIMIT 10
        ");

        return $stmt->fetchAll();
    }
}