# Yii2 Módulo de Controle de Acesso Baseado em Função (RBAC)

O módulo contém uma interface da Web para gerenciar funções, permissões e atribuir direitos aos usuários.

## Conexão

common/config/main.php
```
return [
    // ...        
    'components' => [        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        // ...
    ],
]
```

backend/config/main.php
```
return [
    // ...
    'bootstrap' => [        
        'modules\rbac\Bootstrap',    
    ],
    'modules' => [        
        'rbac' => [
            'class' => 'modules\rbac\Module',
            'params' => [
                'userClass' => 'modules\users\models\User',
            ]
        ],
        // ...
    ],
]
```

console/config/main.php
```
'bootstrap' => [
    // ...
    'modules\rbac\Bootstrap',    
],
...
'modules' => [
    'rbac' => [
        'class' => 'modules\rbac\Module',
        'params' => [
            'userClass' => 'modules\users\models\User',
        ]
    ],
],
```

Aplicar migração:
```
php yii migrate --migrationPath=@yii/rbac/migrations
```

Para inicializar e definir os dados padrão, execute o comando:
```
php yii rbac/init
```

# Links
Painel de controle RBAC
```
/rbac/default/index
```

Gerenciamento de permissões
```
/rbac/permissions/index
```

Gerenciamento de papéis
```
/rbac/roles/index
```

Atribuição de direitos do usuário
```
/rbac/assign/index
```

Definindo configurações padrão do RBAC
```
/rbac/default/reset
```

## Documentação
[Role Based Access Control (RBAC)](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#rbac)

## Licença
A licença BSD (BSD). Por favor, veja o [License File](https://github.com/Dominus77/yii2-advanced-start/blob/master/modules/rbac/LICENSE.md) for more information.

