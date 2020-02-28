<?php
/* Helper con todas las funcciones de manejo de sesión
 * Rafael Reyna
 * */

class Sesion
{

    public $baseurl;
    private $contraloriasocialDB;
    public $dependencia_x = "";
    public $dependencia_id_x = "";
    public $usuario = "";
    public $usuario_id = "";
    public $contrasena = "";
    public $num_contra = "";
    public $nombres_x = "";
    public $apellido_p_x =  "";
    public $apellido_m_x =  "";
    public $ambito_usu_x =  "";
    public $cve_area_x_usu_x =  "";
    public $area_cve_nivel1_usu_x =  "";
    public $urol_id_x_contraloriasocial =  "";
    public $rol_usu_x_contraloriasocial =  "";
    public $esquema_x_contraloriasocial =  "";
    public $usuario_adminsitrador_x_contraloriasocial =  "";
    public $usuario_movil_x_contraloriasocial =  "";

    function __construct($contraloriasocialDB)
    {
        setlocale(LC_MONETARY, 'es_MX');
        session_name('csocial');
        session_start();
        $this->contraloriasocialDB = $contraloriasocialDB;
        date_default_timezone_set('America/Mexico_City');

        if($_SERVER['HTTP_HOST'] == 'contraloriasocial.test')
            $this->baseurl = 'http://contraloriasocial.test/';
        else
            $this->baseurl = 'http://www2.queretaro.gob.mx/sicseq/';
    }

    function cerrar_sesion(){
        $ini_sesion_contraloriasocial = "";
        unset($_SESSION["dependencia_x"]);
        unset($_SESSION["dependencia_id_x"]);
        unset($_SESSION["ini_sesion_contraloriasocial"]);
        unset($_SESSION["usuario_x_contraloriasocial"]);
        unset($_SESSION["nombre_usu_x_contraloriasocial"]);
        unset($_SESSION["ambito_usu_x_contraloriasocial"]);
        unset($_SESSION["cve_area_x_contraloriasocial"]);
        unset($_SESSION["area_cve_nivel1_usu_x_contraloriasocial"]);
        unset($_SESSION["tipo_usu_x_contraloriasocial"]);
        unset($_SESSION["rol_usu_x_contraloriasocial"]);
        unset($_SESSION["esquema_x_contraloriasocial"]);
        unset($_SESSION["usuario_id_x"]);
    }

    function cargar_usuaro_sesion(){
        $_SESSION["ini_sesion_contraloriasocial"] = 'siinicontraloriasocial';
        $_SESSION["usuario_id_x"] = $this->usuario_id;
        $_SESSION["usuario_x_contraloriasocial"] = $this->usuario;
        $_SESSION["dependencia_x"] = $this->dependencia_x;
        $_SESSION["dependencia_id_x"] = $this->dependencia_id_x;
        $_SESSION["nombre_usu_x_contraloriasocial"] = $this->nombres_x.' '.$this->apellido_p_x.' '.$this->apellido_m_x;
        $_SESSION["ambito_usu_x_contraloriasocial"] = $this->ambito_usu_x;
        $_SESSION["cve_area_x_contraloriasocial"] = $this->cve_area_x_usu_x;
        $_SESSION["area_cve_nivel1_usu_x_contraloriasocial"] = $this->area_cve_nivel1_usu_x;
        $_SESSION["urol_id_x_contraloriasocial"] = $this->urol_id_x_contraloriasocial;
        $_SESSION["usuario_adminsitrador_x_contraloriasocial"] = $this->usuario_adminsitrador_x_contraloriasocial;
        $_SESSION["usuario_movil_x_contraloriasocial"] = $this->usuario_movil_x_contraloriasocial;
        $_SESSION["rol_usu_x_contraloriasocial"] = $this->rol_usu_x_contraloriasocial;
        $_SESSION["esquema_x_contraloriasocial"] = $this->esquema_x_contraloriasocial;
    }

    function sesion_activa(){
        if(isset($_SESSION["ini_sesion_contraloriasocial"]) && $_SESSION["ini_sesion_contraloriasocial"] == "siinicontraloriasocial"){
            $this->usuario = $_SESSION["usuario_x_contraloriasocial"];
            $this->usuario_id = $_SESSION["usuario_id_x"];
            $this->dependencia_x = $_SESSION["dependencia_x"];
            $this->dependencia_id_x = $_SESSION["dependencia_id_x"];
            $this->nombre_completo = $_SESSION["nombre_usu_x_contraloriasocial"];
            $this->ambito_usu_x = $_SESSION["ambito_usu_x_contraloriasocial"];
            $this->cve_area_x_usu_x = $_SESSION["cve_area_x_contraloriasocial"];
            $this->area_cve_nivel1_usu_x = $_SESSION["area_cve_nivel1_usu_x_contraloriasocial"];
            $this->urol_id_x_contraloriasocial = $_SESSION["urol_id_x_contraloriasocial"];
            $this->usuario_adminsitrador_x_contraloriasocial = $_SESSION["usuario_adminsitrador_x_contraloriasocial"];
            $this->usuario_movil_x_contraloriasocial = $_SESSION["usuario_movil_x_contraloriasocial"];
            $this->rol_usu_x_contraloriasocial = $_SESSION["rol_usu_x_contraloriasocial"];
            $this->esquema_x_contraloriasocial = $_SESSION["esquema_x_contraloriasocial"];
            return true;
        }
        else{
            return false;
        }
    }

    function login(){
        $usuario_x =$_POST['usuario_x'];
        $contrasena_x =$_POST["clave_log"];
        $vista_usuarios=$this->contraloriasocialDB->SelectLimit("SELECT * FROM usuarios WHERE usuario='$usuario_x'") or die($this->contraloriasocialDB->ErrorMsg());
        $numreg=$vista_usuarios->RecordCount();
        if($numreg > 0){
            $this->usuario = $_POST['usuario_x'];
            $this->usuario_id=$vista_usuarios->Fields('id_usuario');
            $this->dependencia_x=$vista_usuarios->Fields('dependencia');
            $this->dependencia_id_x=$vista_usuarios->Fields('dependencia_id');
            $this->contrasena=$vista_usuarios->Fields('contrasena');
            $this->num_contra=$vista_usuarios->Fields('num_contra');
            $this->nombres_x=$vista_usuarios->Fields('nombres');
            $this->apellido_p_x=$vista_usuarios->Fields('apellido_p');
            $this->apellido_m_x=$vista_usuarios->Fields('apellido_m');
            $this->ambito_usu_x=$vista_usuarios->Fields('ambito');
            $this->cve_area_x_usu_x=$vista_usuarios->Fields('cve_area');
            $this->area_cve_nivel1_usu_x=$vista_usuarios->Fields('area_cve_nivel1');
            $this->urol_id_x_contraloriasocial=$vista_usuarios->Fields('urol_id');
            $this->rol_usu_x_contraloriasocial=$vista_usuarios->Fields('rol_usu');
            $this->esquema_x_contraloriasocial=$vista_usuarios->Fields('esquema');
            $this->usuario_adminsitrador_x_contraloriasocial=$vista_usuarios->Fields('usuario_administrador');
            $this->usuario_movil_x_contraloriasocial=$vista_usuarios->Fields('usuario_movil');
        }
        $vista_usuarios->Close();
        return $numreg;
    }

    function set_flash($titulo, $texto, $tipo = "info"){
        $flash = array();
        $flash['titulo'] = $titulo;
        $flash['texto'] = $texto;
        $flash['tipo'] = $tipo;
        $_SESSION['flash'] = $flash;
    }

    function print_flash(){
        if ( isset($_SESSION['flash']) &&  $_SESSION['flash']) {
            echo "$(document).ready(function(){
                    new PNotify({
                        title: '{$_SESSION['flash']['titulo']}',
                        text: '{$_SESSION['flash']['texto']}',
                        type: '{$_SESSION['flash']['tipo']}',
                        styling: 'bootstrap3'
                    });        
                });";
            unset( $_SESSION['flash']);
        }
    }
}
