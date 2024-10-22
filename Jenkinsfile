pipeline {
    agent any

    stages {
        stage('Clone') {
            steps {
                timeout(time: 2, unit: 'MINUTES'){
                    git branch: 'main', credentialsId: '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', url: 'https://github.com/Mark-Pino/SistemaVentasLaravel.git'
                }
            }
        }
        stage('Install Dependencies') {
            steps {
                script {
                    try {
                        sh 'composer install'
                    } catch (Exception e) {
                        error "Failed to install dependencies: ${e.message}"
                    }
                }
            }
        }
        stage('SonarQube Analysis') {
            steps {
                // Configura SonarQube
                script {
                    def scannerHome = tool 'SonarQubeScanner'
                    withSonarQubeEnv('SonarQube') { // Asegúrate de que este nombre coincida con la configuración en Jenkins
                        sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=sistema_ventas_laravel -Dsonar.sources=. -Dsonar.host.url=http://docker.sonar:9000 -Dsonar.login=squ_3805da18fcef575583bc85ce5c5183b9305c14d9"
                    }
                }
            }
        }
        stage('Build') {
            steps {
                // Ejecuta el build si es necesario
                sh 'npm run build' // O el comando que necesites
            }
        }
        stage('Deploy') {
            steps {
                // Despliega tu aplicación si es necesario
                sh 'php artisan migrate' // O cualquier otro comando relevante
            }
        }
    }
}
