pipeline {
    agent any

    environment {
        PROJECT_PATH = "${WORKSPACE}"  // Raiz do projeto
    }

    stages {
        stage('Build') {
            steps {
                echo 'Construindo containers...'
                sh 'docker-compose build'
            }
        }
        stage('Test') {
            steps {
                echo 'Rodando testes básicos...'
                // Exemplo: apenas checando versão PHP no container
                sh 'docker-compose run --rm web php -v'
            }
        }
        stage('Deploy') {
            steps {
                echo 'Subindo containers...'
                sh 'docker-compose up -d'
            }
        }
    }
}
