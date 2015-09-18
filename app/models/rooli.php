<?php

class Rooli extends BaseModel {

    public $rooliid, $nimi, $kuvaus, $vaativuuskerroin;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function kaikki() {
        $kysely = DB::connection()->prepare('SELECT * FROM Rooli');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $roolit = array();

        foreach ($rivit as $rivi) {
            $roolit[] = new Rooli(array(
                'rooliid' => $rivi['rooliid'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
                'vaativuuskerroin' => $rivi['vaativuuskerroin']
            ));
        }
        return $roolit;
    }

    public static function etsi($rooliid) {
        $kysely = DB::connection()->prepare('SELECT * FROM Rooli WHERE rooliid = :rooliid LIMIT 1');
        $kysely->execute(array('rooliid' => $rooliid));
        $rivi = $kysely->fetch();

        if ($row) {
            $rooli = new Rooli(array(
                'rooliid' => $rivi['rooliid'],
                'nimi' => $rivi['nimi'],
                'kuvaus' => $rivi['kuvaus'],
                'vaativuuskerroin' => $rivi['vaativuuskerroin']
            ));
            return $rooli;
        }
        return null;
    }

    public static function karhun_taidot($karhuid) {
        $kysely = DB::connection()->prepare('SELECT rooli.rooliid, rooli.nimi FROM Rooli, Osaaminen WHERE karhuid = :karhuid AND rooli.rooliid = osaaminen.rooliid');
        $kysely->execute(array('karhuid' => $karhuid));
        $rivit = $kysely->fetchAll();
        $taidot = array();

        foreach ($rivit as $rivi) {
            $taidot[] = new Rooli(array(
                'rooliid' => $rivi['rooliid'],
                'nimi' => $rivi['nimi']
            ));
        }
        return $taidot;
    }

}