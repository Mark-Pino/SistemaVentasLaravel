pipeline {
    agent any

    environment {
        COMPOSE_FILE = 'docker-compose.yml'
    }

    stages {
        stage('Checkout') {
            steps {
                // Obtén el código desde tu repositorio GitHub
                git credentialsId: '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', url: 'https://github.com/Mark-Pino/SistemaVentasLaravel.git', branch: 'main'
            }
        }

        stage('Install Dependencies') {
            steps {
                // Usa Docker para correr composer install
                script {
                    docker.image('composer:2').inside {
                        sh 'composer install --no-interaction --prefer-dist'
                    }
                }
            }
        }

        stage('Run Migrations') {
            steps {
                // Ejecuta las migraciones de Laravel en el contenedor PHP
                script {
                    docker.image('php:8.2-fpm').inside {
                        withEnv(['DB_CONNECTION=mysql', 'DB_HOST=your-db-host', 'DB_DATABASE=your-db', 'DB_USERNAME=your-username', 'DB_PASSWORD=your-password']) {
                            sh 'php artisan migrate --force'
                        }
                    }
                }
            }
        }

        stage('Testing') {
            steps {
                // Aquí puedes añadir cualquier test que quieras correr
                script {
                    docker.image('php:8.2-fpm').inside {
                        sh 'php artisan test'
                    }
                }
            }
        }
    }

    post {
        always {
            // Limpia después de cada ejecución
            cleanWs()
        }
        failure {
            // Notificación en caso de falla
            echo 'El pipeline ha fallado.'
        }
    }
}
