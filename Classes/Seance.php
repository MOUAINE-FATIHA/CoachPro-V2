<?php

class Seance
{
    private $pdo;
    private $id;
    private $id_coach;
    private $date;
    private $heure;
    private $duree;
    private $statut;

    public function __construct(PDO $pdo, $id_coach, $date, $heure, $duree, $statut = 'disponible', $id = null)
    {
        $this->pdo = $pdo;
        $this->id_coach = $id_coach;
        $this->date = $date;
        $this->heure = $heure;
        $this->duree = $duree;
        $this->statut = $statut;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdCoach()
    {
        return $this->id_coach;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getHeure()
    {
        return $this->heure;
    }

    public function getDuree()
    {
        return $this->duree;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setHeure($heure)
    {
        $this->heure = $heure;
    }

    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
    }

    public function creer()
    {
        $sql = "INSERT INTO seances (id_coach, date, heure, duree, statut)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $this->id_coach,
            $this->date,
            $this->heure,
            $this->duree,
            $this->statut
        ]);
    }

    public function modifier($id)
    {
        $sql = "UPDATE seances 
                SET date = ?, heure = ?, duree = ?, statut = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $this->date,
            $this->heure,
            $this->duree,
            $this->statut,
            $id
        ]);
    }

    public function supprimer($id)
    {
        $sql = "DELETE FROM seances WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public static function seancesCoach(PDO $pdo, $id_coach)
    {
        $sql = "SELECT * FROM seances 
                WHERE id_coach = ?
                ORDER BY date, heure";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_coach]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function seancesDisponibles(PDO $pdo)
    {
        $sql = "SELECT s.*, c.discipline 
                FROM seances s
                JOIN coaches c ON s.id_coach = c.id
                WHERE s.statut = 'disponible'
                ORDER BY s.date, s.heure";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
