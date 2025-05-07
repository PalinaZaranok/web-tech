<?php

defined('__ROOT__') or define('__ROOT__', dirname(__DIR__));
defined('__ADMIN__') or define('__ADMIN__', __ROOT__ . '\admin');
defined('__APP__') or define('__APP__', __ROOT__ . '\app');
defined('__PUBLIC__') or define('__PUBLIC__', __ROOT__ . '\public');
defined('__UTILS__') or define('__UTILS__', __ROOT__ . '\utils');

defined('__CONTROLLERS__') or define('__CONTROLLERS__', __APP__ . '\controllers');
defined('__REPOSITORY__') or define('__REPOSITORY__', __APP__ . '\repository');
defined('__SERVICES__') or define('__SERVICES__', __APP__ . '\services');
defined('__TEMPLATES__') or define('__TEMPLATES__', __APP__ . '\templates');
defined('__VIEW__') or define('__VIEW__', __PUBLIC__ . '\view');
defined('__MODELS__') or define('__MODELS__', __APP__ . '\models');

defined('__TEMPLATE_CACHE__') or define('__TEMPLATE_CACHE__', __UTILS__ . '\cache');
