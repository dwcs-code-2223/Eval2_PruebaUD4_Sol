<?php

/* Default options */


const DEFAULT_CONTROLLER = "Usuario";
const DEFAULT_ACTION = "login";

const CONTROLLERS_FOLDER="controller";

const MODELS_FOLDER = "model";

const REPOSITORIES_FOLDER=MODELS_FOLDER.DIRECTORY_SEPARATOR."repository";
const ENTITIES_FOLDER=MODELS_FOLDER.DIRECTORY_SEPARATOR."entity";
const SERVICES_FOLDER=MODELS_FOLDER.DIRECTORY_SEPARATOR."service";

const VIEWDATA_FOLDER = MODELS_FOLDER.DIRECTORY_SEPARATOR."viewData";

const INCLUDES_FOLDER="includes";
const TRAITS_FOLDER=MODELS_FOLDER.DIRECTORY_SEPARATOR."traits";

const IMAGES_FOLDER="files";

const IMAGE_DEFAULT="no-picture.jpg";



const LOGIN_ERROR_MSG = "No se ha podido iniciar sesión";

const ADMIN_ROLE="admin";
const USER_ROLE="user";


CONST MAX_SECONDS_INACTIVITY = 30;
?>