#!/bin/bash

s3fs $S3_BUCKET_NAME $S3_MOUNT_DIRECTORY -o nonempty -o passwd_file=/root/.passwd-s3fs
