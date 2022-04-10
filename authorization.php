<?php

include_once dirname(__FILE__) . '/' . 'phpgen_settings.php';
include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/security/permission_set.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_authentication/table_based_user_authentication.php';
include_once dirname(__FILE__) . '/' . 'components/security/grant_manager/hard_coded_user_grant_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/table_based_user_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_identity_storage/user_identity_session_storage.php';
include_once dirname(__FILE__) . '/' . 'components/security/recaptcha.php';
include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

$grants = array('guest' => 
        array()
    ,
    'defaultUser' => 
        array('tbl_animal' => new PermissionSet(false, false, false, false),
        'tbl_animal.tbl_certificado_vacina' => new PermissionSet(false, false, false, false),
        'tbl_campanha_vacinacao' => new PermissionSet(false, false, false, false),
        'tbl_campanha_vacinacao.tbl_certificado_vacina' => new PermissionSet(false, false, false, false),
        'tbl_certificado_vacina' => new PermissionSet(false, false, false, false),
        'tbl_endeereco_proprietario' => new PermissionSet(false, false, false, false),
        'tbl_endeereco_proprietario.tbl_animal' => new PermissionSet(false, false, false, false),
        'tbl_vacina' => new PermissionSet(false, false, false, false),
        'tbl_vacina.tbl_campanha_vacinacao' => new PermissionSet(false, false, false, false))
    ,
    'jorgecosta' => 
        array('tbl_animal' => new PermissionSet(false, false, false, false),
        'tbl_animal.tbl_certificado_vacina' => new PermissionSet(false, false, false, false),
        'tbl_campanha_vacinacao' => new PermissionSet(false, false, false, false),
        'tbl_campanha_vacinacao.tbl_certificado_vacina' => new PermissionSet(false, false, false, false),
        'tbl_certificado_vacina' => new PermissionSet(false, false, false, false),
        'tbl_endeereco_proprietario' => new PermissionSet(false, false, false, false),
        'tbl_endeereco_proprietario.tbl_animal' => new PermissionSet(false, false, false, false),
        'tbl_vacina' => new PermissionSet(false, false, false, false),
        'tbl_vacina.tbl_campanha_vacinacao' => new PermissionSet(false, false, false, false))
    );

$appGrants = array('guest' => new PermissionSet(false, false, false, false),
    'defaultUser' => new PermissionSet(true, false, false, false),
    'jorgecosta' => new AdminPermissionSet());

$dataSourceRecordPermissions = array();

$tableCaptions = array('tbl_animal' => 'Tbl Animal',
'tbl_animal.tbl_certificado_vacina' => 'Tbl Animal->Tbl Certificado Vacina',
'tbl_campanha_vacinacao' => 'Tbl Campanha Vacinacao',
'tbl_campanha_vacinacao.tbl_certificado_vacina' => 'Tbl Campanha Vacinacao->Tbl Certificado Vacina',
'tbl_certificado_vacina' => 'Tbl Certificado Vacina',
'tbl_endeereco_proprietario' => 'Tbl Endeereco Proprietario',
'tbl_endeereco_proprietario.tbl_animal' => 'Tbl Endeereco Proprietario->Tbl Animal',
'tbl_vacina' => 'Tbl Vacina',
'tbl_vacina.tbl_campanha_vacinacao' => 'Tbl Vacina->Tbl Campanha Vacinacao');

$usersTableInfo = array(
    'TableName' => 'tbl_user',
    'UserId' => 'id_user',
    'UserName' => 'usuario',
    'Password' => 'senha',
    'Email' => '',
    'UserToken' => '',
    'UserStatus' => ''
);

function EncryptPassword($password, &$result)
{

}

function VerifyPassword($enteredPassword, $encryptedPassword, &$result)
{

}

function BeforeUserRegistration($userName, $email, $password, &$allowRegistration, &$errorMessage)
{

}    

function AfterUserRegistration($userName, $email)
{

}    

function PasswordResetRequest($userName, $email)
{

}

function PasswordResetComplete($userName, $email)
{

}

function VerifyPasswordStrength($password, &$result, &$passwordRuleMessage) 
{

}

function CreatePasswordHasher()
{
    $hasher = CreateHasher('');
    if ($hasher instanceof CustomStringHasher) {
        $hasher->OnEncryptPassword->AddListener('EncryptPassword');
        $hasher->OnVerifyPassword->AddListener('VerifyPassword');
    }
    return $hasher;
}

function CreateGrantManager() 
{
    global $grants;
    global $appGrants;
    
    return new HardCodedUserGrantManager($grants, $appGrants);
}

function CreateTableBasedUserManager() 
{
    global $usersTableInfo;

    $userManager = new TableBasedUserManager(MyPDOConnectionFactory::getInstance(), GetGlobalConnectionOptions(), 
        $usersTableInfo, CreatePasswordHasher(), false);
    $userManager->OnVerifyPasswordStrength->AddListener('VerifyPasswordStrength');

    return $userManager;
}

function GetReCaptcha($formId) 
{
    return null;
}

function SetUpUserAuthorization() 
{
    global $dataSourceRecordPermissions;

    $hasher = CreatePasswordHasher();

    $grantManager = CreateGrantManager();

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage(), false, $hasher, CreateTableBasedUserManager(), false, false, false);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
