FROM gitpod/workspace-mysql

USER gitpod

# Install custom tools, runtime, etc. using apt-get
# For example, the command below would install "bastet" - a command line tetris clone:
#
# RUN sudo apt-get -q update && \
#     sudo apt-get install -yq bastet && \
#     sudo rm -rf /var/lib/apt/lists/*
#
# More information: https://www.gitpod.io/docs/config-docker/

# Install Redis.
# RUN sudo apt-get update && \
#     sudo apt-get install -y && \
#     redis-server && \ # Fails with 'redis-server' not found on this workspace-mysql
#     sudo rm -rf /var/lib/apt/lists/*

ENV DATABASE_USER=root
ENV DATABASE_HOST=127.0.0.1
ENV DATABASE_PASSWORD=