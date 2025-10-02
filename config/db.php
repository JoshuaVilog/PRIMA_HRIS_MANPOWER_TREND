<?php
session_start();
class DB {
    private static $conn;

    public static function connection1() {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "1_ms";

        if (!self::$conn) {
            self::$conn = new mysqli($hostname, $username, $password, $database);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
    public static function connectionHRIS() {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "1_hris";

        if (!self::$conn) {
            self::$conn = new mysqli($hostname, $username, $password, $database);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
/* 
Law 3: huwag mo agad ipakita ang tunay mong plano.”

Kapag alam ng iba ang plano mo, pwede ka nilang pigilan, gayahin, o sirain bago ka pa makagalaw.
Kapag tahimik ka, mas kampante sila at hindi nila alam ang susunod mong galaw.

Halimbawa.
Sa school niyo ay may competition. Ang kaklase mo ay todo show off ng kanyang gagawin
Yung isa, todo post ng plans online. Yung isa, tahimik lang pero handang-handa.
Nung event day, nagulat lahat—yung tahimik ang nanalo.
Lesson: Walang kailangang malaman ang plano mo—gawin mo nalang.

[Scenario - Work - 15s]
Sa trabaho, may opening for promotion.
Yung iba, nagsisiraan, nagpapakitang gilas.
Ikaw? Tahimik lang, steady sa trabaho.
Sa huli, ikaw ang pinili—hindi ka drama, puro gawa.

[Advice - 15s]
Ang diskarte?
Wag lahat ipinapakita—lalo na kung hindi pa panahon.
Use distractions, small talk, or neutrality para di mahalata.
Ang tunay na galaw, ginagawa tahimik.
Pag-andar mo na, surprise is your weapon.
*/

?>