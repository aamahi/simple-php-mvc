<?php
/**
 * Base interface representing a generic exception in a container.
 */
interface ContainerExceptionInterface
{
}

interface NotFoundExceptionInterface extends ContainerExceptionInterface
{
}

class NotFoundException extends Exception implements NotFoundExceptionInterface {

}