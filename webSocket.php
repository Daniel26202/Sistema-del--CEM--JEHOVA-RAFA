<?php

require __DIR__ . '/vendor/autoload.php';

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

use App\modelos\Db;

class CitasProximas implements MessageComponentInterface
{
    protected $clients;
    protected $db;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        // Aquí tu conexión a BD (ej: PDO desde tu app)
        $conn = new Db(); // adapta según tu MVC
        $this->db =  $conn->connectionSistema();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nueva conexión (ID: {$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Conexión cerrada (ID: {$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Puedes ignorar si solo manda push desde el servidor
        // O usar mensajes para indicar: "quiero citas próximas"
        $data = json_decode($msg, true);
        if ($data['action'] ?? null === 'get_citas_proximas') {
            $citas = $this->getProximasCitas();
            $from->send(json_encode([
                'type'  => 'citas_proximas',
                'citas' => $citas
            ]));
        }
    }

    private function getProximasCitas()
    {
        $sql = "
             SELECT c.id_cita, p.nombre, p.apellido, c.fecha, c.hora,d.nombre AS
   nombre_d, d.apellido AS apellido_d
            FROM cita c INNER JOIN paciente p ON p.id_paciente= c.paciente_id_paciente  
            INNER JOIN personal d ON d.id_personal = c.doctor
            WHERE c.fecha >= CURDATE()
            ORDER BY c.fecha, c.hora
            LIMIT 5
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function enviarCitasProximasATodos()
    {
        $citas = $this->getProximasCitas();
        $data = json_encode([
            'type'  => 'citas_proximas',
            'citas' => $citas
        ]);

        foreach ($this->clients as $client) {
            $client->send($data);
        }
    }
}

// Iniciar el servidor
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new CitasProximas()
        )
    ),
    8080
);

$server->run();
