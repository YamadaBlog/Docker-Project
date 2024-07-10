# Get target env in first parameter
# Defaults to dev
env=${1:-dev}

get_compose_command() {
  case $1 in
    dev)
      echo "docker compose -f docker-compose.yml"
      ;;
    preprod)
      echo "docker compose -f docker-compose-preprod.yml"
      ;;
    prod)
      echo "docker compose -f docker-compose-prod.yml"
      ;;
    *)
      echo "Error: Invalid environment '$1'. Valid environments are dev, preprod, prod."
      exit 1
      ;;
  esac
}

# Get the compose command for the current environment
compose_command=$(get_compose_command $env)

echo "Starting $env environment"
# The "${@:2}" syntax is used to pass all arguments except the first one to the compose command
$compose_command up "${@:2}"
