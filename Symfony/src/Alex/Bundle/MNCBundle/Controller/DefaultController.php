<?php

namespace Alex\Bundle\MNCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Alex\Bundle\MNCBundle\Entity\Job;
use Alex\Bundle\MNCBundle\Entity\Person;
use Alex\Bundle\MNCBundle\Entity\Attendance;


class DefaultController extends Controller
{
    public function indexAction($name="") {
        return $this->render('AlexMNCBundle:Default:index.html.twig', array('name' => $name));
    }

    private function allInArray(array $to_check, array $parameters) {
    	foreach ($to_check as $rp) {
			if(!isset($parameters[$rp])) {												
				return false;
			}
		}
		return true;
    }

    public function newPersonAction(Request $request) {
    	$status = 200;
    	$response = array();
    	if ($request->getMethod() == "POST") {    		
	     	$required_p = array("firstname","lastnames","address");	     	
			$parameters = $request->request->all();
	     	$is_valid = $this->allInArray($required_p,$parameters);	     	
			if ($is_valid) {
				$em = $this->getDoctrine()->getManager(); 
				$em = $this->getDoctrine()->getManager(); 
				$person = new Person();
				$person->setFirstName($parameters["firstname"]);
				$person->setLastNames($parameters["lastnames"]);
				$person->setAddress($parameters["address"]);				
				$response = $person;
				$em->persist($person);								
				$em->flush();
				$response = array("id" => $person->getUserId());
			} else {
			    $response = array("error" => "Required parameters");
			}
		} else {
 			$status = 405;
 			$response = array ("error" => "Invalid method.");
		}
		return new Response(json_encode($response), $status, array("Content-Type" => "application/json"));
    }
    
    public function getPeopleAction(Request $request) {
        if ($request->getMethod() != "POST") {	
            $status = 200;
            $em = $this->getDoctrine()->getManager(); 
            $people = $em->getRepository("AlexMNCBundle:Person")->findAll();
            $response = array();
            foreach($people as $person) {
                $r = array();
                $r["user_id"] = $person->getUserId();
                $r["fullname"] = $person->getFirstName() . " " . $person->getLastNames();
                array_push($response,$r);
            }
            return new Response(json_encode($response), $status, array("Content-Type" => "application/json"));
        } else {
            return $this->newPersonAction($request);
        }   
    }
    

    private function newJobAction(Request $request) {
    	$status = 200;
    	$response = array();
	    if ($request->getMethod() == "POST") {			
			$required_p = array("description","salary");
			$parameters = $request->request->all();
			$is_valid = $this->allInArray($required_p,$parameters);
		 	if ($is_valid) {
		 		$em = $this->getDoctrine()->getManager(); 
				$j = new Job();
				$immediate = $em->getRepository("AlexMNCBundle:Person")->find($parameters["immediate"]);
				$j->setDescription($parameters["description"]);
				$j->setImmediate($immediate);
				$j->setSalary($parameters["salary"]);
				$em->persist($j);
				$em->flush();
				$response = array("id" => $j->getJobId());
		    } else {
		        $response = array("error" => "Required parameters");
		        $status = 400;
		    }
		} else {
			$status = 405;
			$response = array ("error" => "Invalid method.");
		}
		return new Response(json_encode($response), $status, array("Content-Type" => "application/json"));
    }
    
    public function getJobsAction(Request $request) {
        if ($request->getMethod() != "POST") {	
            $status = 200;
            $em = $this->getDoctrine()->getManager(); 
            $jobs = $em->getRepository("AlexMNCBundle:Job")->findAll();
            $response = array();
            foreach($jobs as $job) {
                $r = array();
                $r["job_id"] = $job->getJobId();
                $r["description"] = $job->getDescription();
                array_push($response, $r);
            }
            return new Response(json_encode($response), $status, array("Content-Type" => "application/json"));
        } else {
            return $this->newJobAction($request);
        }
    }

	public function addPersonJobRelAction(Request $request) {
		$status = 200;
		$response = array();
	    if ($request->getMethod() == "POST") {
	    	$required_p = array("user_id","job_id");
			$parameters = $request->request->all();
			$is_valid = $this->allInArray($required_p,$parameters);
			if ($is_valid) {
			    $em = $this->getDoctrine()->getManager(); 
                $person = $em->getRepository("AlexMNCBundle:Person")->find($parameters["user_id"]);
                $job = $em->getRepository("AlexMNCBundle:Job")->find($parameters["job_id"]);
                $person->addJob($job);
                $em->flush();
                $response = array("user_id" => $person->getUserId(), "job_id" => $job->getJobId());
			} else {
		        $response = array("error" => "Required parameters");
		        $status = 400;
		    }
	    } else {
	    	$status = 405;
			$response = array ("error" => "Invalid method.");			
	    }
	    return new Response(json_encode($response), $status, array("Content-Type" => "application/json"));
	}
	
	private function checkAttendanceAction(Request $request) {
	    $status = 200;
	    if ($request->getMethod() == "POST") {
	        $required_p = array("user_id");
			$parameters = $request->request->all();
			$is_valid = $this->allInArray($required_p,$parameters);
			if ($is_valid) {
			    $em = $this->getDoctrine()->getManager(); 
                $person = $em->getRepository("AlexMNCBundle:Person")->find($parameters["user_id"]);
                $att = new Attendance();
                $att->setUser($person);
                $em->persist($att);
                $em->flush();
                $response = array("att_id" => $att->getAttId());
			} else {
		        $response = array("error" => "Required parameters");
		        $status = 400;
		    }
	    } else {
            $status = 405;
            $response = array ("error" => "Invalid method.");			
	    }
	    return new Response(json_encode($response), $status, array("Content-Type" => "application/json"));
	}
	
	public function getAttendancesAction(Request $request) {
        if ($request->getMethod() != "POST") {	
            $status = 200;
            $parameters = $request->query->all();
            $em = $this->getDoctrine()->getManager(); 
            if (isset($parameters["user_id"])) {
                $atts = $em->getRepository("AlexMNCBundle:Attendance")->findBy(array("user" => $parameters["user_id"]));
            } else {
                $atts = $em->getRepository("AlexMNCBundle:Attendance")->findAll();
            }
            $response = array();
            foreach($atts as $att) {
                $r = array();
                $r["att_id"] = $att->getAttId();
                $r["fullname"] = $att->getUser()->getFirstName() . " " . $att->getUser()->getLastNames();
                $jobs = array();
                foreach($att->getUser()->getJob() as $job) {
                    $j = array();
                    $j["job_id"] = $job->getJobId();
                    $j["description"] = $job->getDescription();
                    array_push($jobs, $j);
                }
                $r["job"] = $jobs;
                $r["date"] = $att->getCheckHour();
                array_push($response, $r);
            }
            return new Response(json_encode($response), $status, array("Content-Type" => "application/json"));
        } else {
            return $this->checkAttendanceAction($request);
        }
	}
}
