<?php
class Reservation
{
    private $pdo;
    private $id;
    private $id_seance;
    private $id_sportif;
    private $date_reserv;
    public function __construct(PDO $pdo, $id_seance, $id_sportif, $id = null, $date_reserv = null){
        $this->pdo = $pdo;
        $this->id_seance = $id_seance;
        $this->id_sportif = $id_sportif;
        $this->id = $id;
        $this->date_reserv = $date_reserv;
    }
    public function getId(){ 
        return $this->id; 
    }
    public function getIdSeance(){ 
        return $this->id_seance; 
    }
    public function getIdSportif(){ 
        return $this->id_sportif; 
    }
    public function getDateReservation(){ 
        return $this->date_reserv; 
    }

    public function creer(){
        $check = $this->pdo->prepare("SELECT statut FROM seances WHERE id = ?");
        $check->execute([$this->id_seance]);
        $seance = $check->fetch();
        if (!$seance || $seance['statut'] !=='disponible') {
            return false;
        }
        $sql = "INSERT INTO reservations (id_seance, id_sportif, statut) VALUES (?, ?, 'pending')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->id_seance, $this->id_sportif]);
        $update = $this->pdo->prepare("UPDATE seances SET statut ='reservee' WHERE id= ?");
        $update->execute([$this->id_seance]);
        return true;
    }
    public static function reservationsSportif(PDO $pdo, $id_sportif){
        $sql = "SELECT s.date, s.heure, s.duree, c.discipline FROM reservations r
                JOIN seances s ON r.id_seance=s.id
                JOIN coaches c ON s.id_coach=c.id
                WHERE r.id_sportif =? AND r.statut = 'accepted'
                ORDER BY s.date, s.heure";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_sportif]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function reservationsCoach(PDO $pdo, $id_coach){
        $sql = "SELECT r.id, s.date, s.heure, s.duree, u.nom, u.prenom, r.statut FROM reservations r
                JOIN seances s ON r.id_seance=s.id
                JOIN sportifs sp ON r.id_sportif=sp.id
                JOIN users u ON sp.id_user =u.id
                WHERE s.id_coach = ? AND r.statut ='pending'
                ORDER BY s.date, s.heure";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_coach]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function updateStatut(PDO $pdo, $reservationId, $statut){
        $allowed = ['accepted', 'refused'];
        if (!in_array($statut, $allowed)) return false;

        if($statut === 'refused'){
            $stmt = $pdo->prepare("SELECT id_seance FROM reservations WHERE id = ?");
            $stmt->execute([$reservationId]);
            $res = $stmt->fetch();
            if($res){
                $updateSeance = $pdo->prepare("UPDATE seances SET statut = 'disponible' WHERE id = ?");
                $updateSeance->execute([$res['id_seance']]);
            }
        }
        $stmt = $pdo->prepare("UPDATE reservations SET statut = ? WHERE id = ?");
        return $stmt->execute([$statut, $reservationId]);
    }
}
