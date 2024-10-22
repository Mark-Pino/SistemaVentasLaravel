pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Clona tu repositorio
                git 'https://github.com/Mark-Pino/SistemaVentasLaravel.git'
            }
        }
        stage('Install Dependencies') {
            steps {
                // Instala las dependencias de Composer
                sh 'composer install'
            }
        }
        stage('SonarQube Analysis') {
            steps {
                // Configura SonarQube
                script {
                    def scannerHome = tool 'SonarQubeScanner'
                    withSonarQubeEnv('SonarQube') { // Nombre de la configuración de SonarQube en Jenkins
                        sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=sistema_ventas_laravel -Dsonar.sources=. -Dsonar.host.url=http://docker.sonar:9000 -Dsonar.login=squ_3805da18fcef575583bc85ce5c5183b9305c14d9"
                    }
                }
            }
        }
        stage('Build') {
            steps {
                // Ejecuta el build si es necesario
                // sh 'npm run build' o cualquier otro comando relevante
            }
        }
        stage('Deploy') {
            steps {
                // Despliega tu aplicación si es necesario
                // sh 'php artisan migrate' u otros comandos
            }
        }
    }
}
